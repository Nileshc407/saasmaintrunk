
<?php /* ?>

<!-- Modal content-->
	<div >
	
		<div id="printThis"  class="modal-content">
		
			
			
			<div style="text-align: center;">
					<h5 class="form-header"><b>
					 <?php				
						if($Transaction_type == 1){echo "Bonus ".$Company_details->Currency_name." Receipt";}
						if($Transaction_type == 2 || $Transaction_type == 12){echo "Purchase Receipt";}
						if($Transaction_type == 3 || $Transaction_type == 10){echo "Redeem ".$Company_details->Currency_name." Receipt";}
						if($Transaction_type == 4){echo "Gift Card Transaction Receipt";}
						?>
						</b>
					</h5>
					<div class="form-desc">
					  <b><?php echo $Company_name; ?></b><br>
					  Merchant Outlet:<?php echo $Company_name; ?><br>
					  Address : <?php echo $Seller_address; ?>
					</div>
					<div class="form-desc">
					  Bill No. : <b><?php echo $Bill_no; ?></b><br>
					  <?php if($Transaction_type != 3 && $Transaction_type != 10  && $Transaction_type != 12 && $Remark != "Joining Bonus" && $Remark != "Referral Trans"){ ?>
							Manual Bill No. : <b><?php echo $Manual_billno ;?></b>
						<?php } ?><br>
					  Transaction Date : <b><?php echo $Transaction_date; ?></b>
					</div>		
				</div>
		
		
		
			<div class="table-responsive">
				<table  class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>Member Name</th>
						<td><?php echo $Cust_full_name; ?></td>
					</tr>
					
					<tr>
						<th>Address</th>
						<td><?php echo $Cust_address; ?></td>
					</tr>
					
					<tr>
						<th>Email</th>
						<td><?php echo $User_email_id; ?></td>
					</tr>
					
					<tr>
						<th>Phone no</th>
						<td><?php echo $Cust_phone_no; ?></td>
					</tr>
					
					<?php if($Transaction_type == 2){ ?>
					<tr>
						<th>Category</th>
						<td><strong><?php echo $Item_category_name; ?></strong></td>
					</tr>
					<?php } ?>
					
					<?php if($Transaction_type == 10){ ?>
					<tr>
						<th>Redeemed Item(s)</th>
						<td><strong><?php echo $Redeemed_item; ?></strong></td>
					</tr>
					<?php } ?>
					
					<tr>
						<th> <?php if($Transaction_type == 1){ echo "Bonus ".$Company_details->Currency_name." Issued"; }
							else if($Transaction_type == 10 || $Transaction_type == 3){ echo "Total ".$Company_details->Currency_name." Redeemed"; }
							else{ echo "Transaction"; }
							if($Transaction_type != 1 &&$Transaction_type != 3 && $Transaction_type != 10){echo "( ".$Symbol_currency." )";} ?>
						</th>
						<td>
							<strong>
								<?php 
								// echo $Topup_amount; 
								if($Transaction_type == 1){ echo $Topup_amount; }
								if($Transaction_type == 2){echo $Purchase_amount. " ( Purchase Amount)";}
								if($Transaction_type == 3){echo $Redeem_points;}
								if($Transaction_type == 4){echo $giftcard_purchase. " ( Purchase Amount)";}
								if($Transaction_type == 10){echo $Total_redeem_points; }
								?>
							</strong>
						</td>
					</tr>					
					<?php if($Transaction_type == 2 || $Transaction_type == 4){ ?>
					<tr>
						<th>
							<?php
							if($Transaction_type == 2){echo "Redeemed ".$Company_details->Currency_name;}
							if($Transaction_type == 4){echo " Redeem Amount";}
							?>
						</th>
						<td>
							<strong>
								<?php 
								if($Transaction_type == 2 || $Transaction_type == 4){echo $Redeem_points;}
								?>
							</strong>
						</td>
					</tr>
					
					<tr>
						<th>Balance Paid ( <?php echo $Symbol_currency; ?> ) </th>
						<td>
							<strong>
								<?php 
								if($Transaction_type == 2 || $Transaction_type == 4){echo $balance_to_pay;}
								?>
							</strong>
						</td>
					</tr>
					<tr>
						<th>Balance Payment by</th>
						<td>
							<strong>
								<?php 
								echo $Payment_description;
								
								?>
							</strong>
						</td>
					</tr>
					<?php if($Payment_type_id != 1 && $Transaction_type == 2){?>
					<tr>
						<th>Bank Name</th>
						<td>
							<strong>
								<?php 
								echo $Bank_name;
								
								?>
							</strong>
						</td>
					</tr>
					<tr>
						<th>Bank Branch Name</th>
						<td>
							<strong>
								<?php 
								echo $Branch_name;
								
								?>
							</strong>
						</td>
					</tr>
					<tr>
						<th>Cheque/Credit Number</th>
						<td>
							<strong>
								<?php 
								echo $Credit_Cheque_number;
								
								?>
							</strong>
						</td>
					</tr>
					<?php } ?>
					<?php if($Transaction_type == 4){ ?>
						<tr>
						<th>Gift Card No</th>
						<td>
							<strong>
								<?php 
								
								echo $gift_pay_type;
								?>
							</strong>
						</td>
					</tr>
						<?php } ?>
						
					<?php } ?>
					
					<?php 
						if($Transaction_type == 10 ){
					?>
					<!--<tr>
						<th>Voucher No.</th>
						<td>
							<strong>
								<?php 
								//echo $Voucher_no;
								?>
							</strong>
						</td>
					</tr>
					
					<tr>
						<th>Voucher Status</th>
						<td>
							<strong>
								<?php 
								//echo $Voucher_status;
								?>
							</strong>
						</td>
					</tr> -->
					<?php 
					}
					?>
					<?php  if($Transaction_type == 2) { ?>
					<tr>
						<th>						
							<?php  if($Coalition == 1) { ?>
								 <?php echo $Company_details->Currency_name; ?> Gained at Merchant
							<?php  } else { ?>
								Total <?php echo $Company_details->Currency_name; ?> Gained
							<?php  } ?>
						</th>
						<td>
							<strong>
								<?php 
								echo $Loyalty_pts;
								?>
							</strong>
						</td>
					</tr>
					<?php  if($Coalition == 1){ ?>
						<tr>
							<th> <?php echo $Company_details->Currency_name; ?> Gained due to Coalition </th>
							<td>
								<strong>
									<?php 
									echo round($Coalition_Loyalty_pts);
									?>
								</strong>
							</td>
						</tr>
					<?php  } ?>
					<?php } ?>
					<tr>
						<th>Remark</th>
						<td>
							<?php
							if($Transaction_type == 4)
							{
								echo "Gift Card Transaction";
							}
							
							if(($Transaction_type == 2 || $Transaction_type == 1 || $Transaction_type == 3|| $Transaction_type == 10) && $Remark!="")
							{
								echo $Remark;
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
						<th>Flatfile Remarks</th>
						<td>
							<?php echo $Flatfile_remarks;?>
						</td>
					</tr>
					
					
					<?php 
						}
					
					?>
					
					
					
					<?php  if($Transaction_type == 2 && $GiftCardNo != "0"){ ?>
					<tr>
						<th>Gift Card No. </th>
						<td>
							<strong>
								<?php 
								if($GiftCardNo==0){echo "-";}else{echo $GiftCardNo;};
								
								?>
							</strong>
						</td>
					</tr>
					<?php } ?>
					
					<?php  if(($Transaction_type == 2 && $Voucher_no != "" && $Voucher_no != "PromoCode-()" ) ){ ?>
					<tr>
						<th>Promo Code Used </th>
						<td>
							<strong>
								<?php 
								echo $Voucher_no;
								?>
							</strong>
						</td>
					</tr>
					<?php } ?>
					
					
					
					</thead>
				</table>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<h4 class="modal-title text-left">
						<?php
							if($Timezone == "Asia/Kolkata" || $Timezone == "") 
							{	
								$Timezone="Asia/Calcutta";
							}
							
							$date = date_default_timezone_set($Timezone);
							echo "<small>".date("F j, Y, g:i a T")."</small>";
							
							
						?>
					</h4>
				</div>
				<div class="col-md-6">
					<h4 class="modal-title text-right">Transaction Done :<small> <?php echo $Seller_name; ?></small></h4>
				</div>
			</div>
			
		</div>
		<div class="modal-footer">
			<button type="button" id="btnPrint"  class="btn btn-primary">Print</button>
			<!--<button type="button" id="close_modal" class="btn btn-primary">Cancel</button>-->
		</div>
	</div>
<!-- Modal content-->

<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
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
<?php */ ?>


<!DOCTYPE html>
<html>
  <body style="background-color: #222533; padding: 20px; font-family: font-size: 12px; line-height: 1.43; font-family: &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;">
    <!--max-width: 600px; --->
    <div style="margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">      
		<!--<img alt="" src="<?php echo base_url(); ?>images/email-header-img.jpg" style="max-width: 100%; height: auto;"> -->
		<div style="padding: 0px 20px;">
			<?php /* ?>
			<h2 class="text-center" style="margin-top: 0px;">
			   <?php				
						if($Transaction_type == 1){echo "Bonus ".$Company_details->Currency_name." Receipt";}
						if($Transaction_type == 2 || $Transaction_type == 12){echo "Purchase Receipt";}
						if($Transaction_type == 3 || $Transaction_type == 10){echo "Redeem ".$Company_details->Currency_name." Receipt";}
						if($Transaction_type == 4){echo "Gift Card Transaction Receipt";}
						?>
			</h2>
			<div style="color: #636363; font-size: 12px;">
				
				Merchant Outlet:<b><?php echo $Company_name; ?></b><br>
				Address : <b><?php echo $Seller_address; ?></b><br>
				Bill No. : <b><?php echo $Bill_no; ?></b><br>
				 <?php if($Transaction_type != 3 && $Transaction_type != 10  && $Transaction_type != 12 && $Remark != "Joining Bonus" && $Remark != "Referral Trans"){ ?>
				Manual Bill No. : <b><?php echo $Manual_billno ;?></b><br>
				<?php } ?>
				Transaction Date : <b><?php echo $Transaction_date; ?></b>
			</div>
			<?php */ ?>
			
			<h2 class="text-center" style="margin-top: 0px;">
			   <?php				
						if($Transaction_type == 1){echo "Bonus ".$Company_details->Currency_name." Receipt";}
						if($Transaction_type == 2 || $Transaction_type == 12){echo "Purchase Receipt";}
						if($Transaction_type == 3 || $Transaction_type == 10){echo "Redeem ".$Company_details->Currency_name." Receipt";}
						if($Transaction_type == 4){echo "Gift Card Transaction Receipt";}
						?>
			</h2>
			<table style="margin-top:5px; width: 100%;">
				  <tr>
					<td style="padding-right: 30px;">
					  <div style="font-size: 11px; letter-spacing: 1px;  color: #020202; margin-bottom: 5px;">
						Merchant Outlet:<b> <?php echo $Company_name; ?></b>
					  </div>
					  <div style="font-size: 11px; letter-spacing: 1px;  color: #020202; margin-bottom: 5px;">
						Address:<b><?php echo App_string_decrypt($Seller_address); ?></b>
					  </div>
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Bill No.:<b><?php echo $Bill_no; ?></b>
					  </div>
					   <?php if($Transaction_type != 3 && $Transaction_type != 10  && $Transaction_type != 12 && $Remark != "Joining Bonus" && $Remark != "Referral Trans"){ ?>
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Manual Bill No.:<b><?php echo $Manual_billno; ?></b>
					  </div>
					  <?php } ?>
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Transaction Date:<b><?php echo $Transaction_date; ?></b>
					  </div>
					</td>
				  </tr>
			</table>
			
			<!--<a href="JavaScript:void(0);" style="padding: 5px 15px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 12px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">View Order Details</a> -->
			<hr style="height:3px; border:none; color:rgb(60,90,180); background-color:rgb(60,90,180);">
			<div class="table-responsive">
				<table style="margin-top:5px; width: 100%;">
				  <tr>
					<td style="padding-right: 30px;">
					  <div style="font-size: 11px; letter-spacing: 1px;  color: #020202; margin-bottom: 5px;">
						Member Name:<b> <?php echo $Cust_full_name; ?></b>
					  </div>
					  <div style="font-size: 11px; letter-spacing: 1px;  color: #020202; margin-bottom: 5px;">
						Address:<b><?php echo App_string_decrypt($Cust_address); ?></b>
					  </div>
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Email:<b><?php echo App_string_decrypt($User_email_id); ?></b>
					  </div>
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Phone no.:<b><?php echo App_string_decrypt($Cust_phone_no); ?></b>
					  </div>
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Membership ID:<b><?php echo $Cust_card_id; ?></b>
					  </div>
					</td>
					<!--
					<td style="max-width: 150px;">
					  <div style="background-color: #fffae9; padding: 20px; font-size: 12px;">
						<h6 style="margin: 0px 0px 10px;">
						  Changed your mind?
						</h6>
						<div style="color: #aaa;">
						  You can request a cancellation within 24 hours by <a href="JavaScript:void(0);" style="text-decoration: underline; color: #4B72FA;">clicking here</a>
						</div>
					  </div>
					</td>-->
				  </tr>
				</table>
			</div>
			
			<hr style="height:3px; border:none; color:rgb(60,90,180); background-color:rgb(60,90,180);">
			<div class="table-responsive">
				<table style="margin-top: 40px; width: 100%;" class="table table-striped">
				<?php if($Transaction_type == 2){ ?>
				  <tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px;">			
					 Category
					</td>
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: right;">
					 <?php echo $Item_category_name; ?>
					</td>
					
				  </tr>
				  <?php } ?>
				  <?php if($Transaction_type == 10){ ?>
				  <tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
					 Redeemed Item(s)
					</td>
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: left;">
					 <?php echo $Redeemed_item; ?>
					</td>
					
				  </tr>
				  <?php } ?>
				  <?php if($Transaction_type == 12){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;">			
						 Purchase Item(s)
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
						 <?php echo $Purchase_item; ?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
						 Total Purchase Amount <?php echo "( ".$Symbol_currency." )";?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
						 <?php echo $Total_purchase; ?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
						 Balance Paid <?php echo "( ".$Symbol_currency." )";?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
						 <?php echo $balance_to_pay; ?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
						 Redeemed <?php echo $Company_details->Currency_name; ?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
						 <?php echo $Redeem_points; ?>
						</td>				
					</tr>
				  
				  <?php } else { ?>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							<?php if($Transaction_type == 1){ echo "Bonus ".$Company_details->Currency_name." Issued"; }
								else if($Transaction_type == 10 || $Transaction_type == 3){ echo "Total ".$Company_details->Currency_name." Redeemed"; }
								else{ echo "Transaction"; }
								if($Transaction_type != 1 &&$Transaction_type != 3 && $Transaction_type != 10){echo "( ".$Symbol_currency." )"; }
							?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: right;">
							<?php 
								// echo $Topup_amount; 
								if($Transaction_type == 1){ echo $Topup_amount; }
								if($Transaction_type == 2){ echo " ( Purchase Amount) ".$Purchase_amount; }
								if($Transaction_type == 3){ echo $Redeem_points;}
								if($Transaction_type == 4){ echo " ( Purchase Amount) ". $giftcard_purchase; }
								if($Transaction_type == 10){ echo $Total_redeem_points; }
							?>
						</td>
				 <?php } ?>
				 
				<?php if($Transaction_type == 2 || $Transaction_type == 4){  ?>
				  <tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
						<?php
							if($Transaction_type == 2){echo "Redeemed ".$Company_details->Currency_name;}
							if($Transaction_type == 4){echo " Redeem Amount";}
						?>
					</td>
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: right;">
						<?php 
							if($Transaction_type == 2 || $Transaction_type == 4){echo $Redeem_points;}
						?>
					</td>
					
				  </tr>
				  <tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
						Balance Paid
					</td>
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: right;">
						<?php 
							if($Transaction_type == 2 || $Transaction_type == 4){echo $balance_to_pay;}
						?>
					</td>
					
				  </tr>
				  
				  <?php if($Transaction_type == 4){ ?>
				  <tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px;">			
						Gift Card No.
					</td>
					<td style="letter-spacing: 1px; color: #020202; font-size: 12px;text-align: right;">
						<?php								
							echo $gift_pay_type;
						?>
					</td>
					
				  </tr>
				  <?php }
				  
				  } ?>
				  
				<?php if($Transaction_type == 2){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Total <?php echo $Company_details->Currency_name ?> Gained 
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: right;">
							<?php 
								echo $Loyalty_pts;
							?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Balance Payment by
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
							<?php  echo $Payment_description; ?>
						</td>				
					</tr>
				  <?php } ?> 
				  
				  <?php if($Payment_type_id != 1 && $Transaction_type == 2){?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Bank Name
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
							<?php 
								echo $Bank_name;
							?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Bank Branch Name
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
							<?php  echo $Branch_name; ?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Cheque/Credit Number
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; text-align: right;">
							<?php  echo $Credit_Cheque_number; ?>
						</td>				
					</tr>
				  <?php } ?> 
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Remark
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
							<?php
								if($Transaction_type == 4)
								{
									echo "Gift Card Transaction";
								}
								
								if(($Transaction_type == 2 || $Transaction_type == 1 || $Transaction_type == 3|| $Transaction_type == 10) && $Remark!="")
								{
									echo $Remark;
								}
								else
								{
									echo " - ";
								}
							?>
						</td>				
					</tr>
					<?php  if($Transaction_type == 2 && $GiftCardNo != "" && $GiftCardNo != 0){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Gift Card Used
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
							<?php
								echo $GiftCardNo;
							?>
						</td>				
					</tr>
					<?php } ?>
					
					<?php  if(($Transaction_type == 2 && $Voucher_no != "" && $Voucher_no != "PromoCode-()" ) ){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px; ">			
							Promo Code Used
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 12px;  text-align: right;">
							<?php
								echo $Voucher_no;
							?>
						</td>				
					</tr>
					<?php } ?>
				  
				 
				</table>
			</div>
			<!--<table style="margin-left: auto; margin-top: 0px; border-top: 3px solid #eee; padding-top: 10px; margin-bottom: 20px;">
			  <tr>
				<td style="color: #B8B8B8; font-size: 12px; padding: 5px 0px;">
				  Subtotal:
				</td>
				<td style="color: #111; text-align: right; font-weight: bold; padding: 5px 0px 5px 40px; font-size: 12px;">
				  $145.98
				</td>
			  </tr>
			  <tr>
				<td style="color: #B8B8B8; font-size: 12px; padding: 5px 0px;">
				  Tax:
				</td>
				<td style="color: #111; text-align: right; font-weight: bold; padding: 5px 0px 5px 40px; font-size: 12px;">
				  $12.83
				</td>
			  </tr>
			  <tr>
				<td style="color: #B8B8B8; font-size: 12px; padding: 5px 0px;">
				  Shipping
				</td>
				<td style="color: #111; text-align: right; font-weight: bold; padding: 5px 0px 5px 40px; font-size: 12px;">
				  $0.00
				</td>
			  </tr>
			  <tr>
				<td style="color: #B8B8B8; font-size: 12px; padding: 5px 0px;">
				  Discount
				</td>
				<td style="color: #45BB4C; text-align: right; font-weight: bold; padding: 5px 0px 5px 40px; font-size: 12px;">
				  - $14.99
				</td>
			  </tr>
			  <tr>
				<td style="color: #111; letter-spacing: 1px; font-size: 20px; padding: 10px 0px; text-transform: uppercase; font-weight: bold;">
				  Total
				</td>
				<td style="color: #4B72FA; text-align: right; font-weight: bold; padding: 10px 0px 5px 40px; font-size: 20px;">
				  $169.34
				</td>
			  </tr>
			</table> 
			<div style="color: #636363; font-size: 12px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05); margin-bottom: 50px;">
			  Thank you again for visiting with us. We appreciate your business and look forward to serving you in the near future.
			</div>
			-->
			
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