	<div id="printThis" class="modal-content">
			
			<div class="table-responsive">
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
						<th>Phone no.</th>
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
					
					<?php if($Transaction_type == 12){ ?>
					
					<tr>
						<th>Purchase Item(s)</th>
						<td><strong><?php echo $Purchase_item; ?></strong></td>
					</tr>
					<tr>
						<th>Total Purchase Amount <?php echo "( ".$Symbol_currency." )";?></th>
						<td><strong><?php echo $Total_purchase; ?></strong></td>
					</tr>
					<tr>
						<th>Balance Paid <?php echo "( ".$Symbol_currency." )";?></th>
						<td><strong><?php echo $balance_to_pay; ?></strong></td>
					</tr>
					<tr>
						<th>Redeemed <?php echo $Company_details->Currency_name; ?> </th>
						<td><strong><?php echo $Redeem_points; ?></strong></td>
					</tr>
					
					<?php } else { ?>
					
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
					<?php } if($Transaction_type == 2 || $Transaction_type == 4){ ?>
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
						<th>Balance Paid</th>
						<td>
							<strong>
								<?php 
								if($Transaction_type == 2 || $Transaction_type == 4){echo $balance_to_pay;}
								?>
							</strong>
						</td>
					</tr>
					
					<?php if($Transaction_type == 4){ ?>
						<tr>
						<th>Gift Card No.</th>
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
					
					
					<?php  if($Transaction_type == 2){ ?>
					<tr>
						<th>Total <?php echo $Company_details->Currency_name ?> Gained </th>
						<td>
							<strong>
								<?php 
								echo $Loyalty_pts;
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
					<?php } ?>
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
					<?php  if($Transaction_type == 2 && $GiftCardNo != "" && $GiftCardNo != 0){ ?>
					<tr>
						<th>Gift Card Used </th>
						<td>
							<strong>
								<?php 
								echo $GiftCardNo;
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
			
		
		<div class="modal-footer">
			<button type="button" id="btnPrint"  class="btn btn-primary">Print</button>
		</div>
	</div>
<!-- Modal content-->

<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#receipt_myModal').modal('show');
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
