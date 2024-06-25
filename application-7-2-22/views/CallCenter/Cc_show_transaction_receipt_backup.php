<!-- Modal content--> 
	<div class="modal-content"  style="overflow:auto;margin-top:41%;">
		<div class="modal-header text-center" align="center">
		<h4 class="text-center" style="text-align:center !important;color:red;    width: 100%;">
				Transaction Receipt
		</h4>
	
		</div>
		<div class="modal-header text-left">
		
				<div>
					Trans. Date : <small><?php echo $Transaction_date; ?></small>
				</div>
				
				
		
		</div>
		
		<div class="modal-body">
			<div class="table-responsive">
				<table  class="table table-bordered table-hover">
					<thead>
					<tr>
					<?php 
						if($Transaction_type == 2 || $Transaction_type == 12 || $Transaction_type == 17 || $Transaction_type == 22 || $Transaction_type == 4)
						{
							if($Bill_no !=NULL && $Bill_no!=0)
							{ ?> 
							<th>Bill No.</th>
							<td><?php echo $Bill_no; ?></td>
					<?php	}
						}
					?>
					</tr>
					<tr>
						<th>Trans. Type</th>
						<td><?php
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
						?></td>
					
					</tr>
					<tr>
					<?php 
						if($Transaction_type == 10 || $Transaction_type == 18)
						{
							 ?> 
							<th>Voucher No.</th>
							<td><?php echo $Voucher_no; ?></td>
					<?php	
						}
					?>
					</tr>
					<tr>
					
						<th>Description</th>
						<?php if($Transaction_type == 10 || $Transaction_type == 12 || $Transaction_type == 17 || $Transaction_type == 18 || $Transaction_type == 22) 
						{ ?>
							<td><strong><?php echo $Redeemed_item; ?></strong></td>
				<?php   } 
						else if($Transaction_type == 8)
						{ ?>
							<td><strong><?php echo 'Transferred To - '.$Card_id2; ?></strong></td>
				<?php	}
						else if($Transaction_type == 7)
						{ ?>
							<td><strong><?php echo $remark2; ?></strong></td>
				<?php	}
				        else   
						{ ?>
							<td><strong><?php echo '-'; ?></strong></td> 
				<?php 	} ?>
					</tr>
					<?php if($Transaction_type == 12) { ?>
					<tr>
						<th>Purchase Amount<?php echo "( ".$Symbol_currency." )"; ?></th>
						<td><?php echo $Purchase_amount; ?></td>
					</tr>
					<?php } ?>
					<tr>
						<th><?php echo $Company_details->Currency_name; ?> Received</th>
				<?php	if($Transaction_type == 1 || $Transaction_type == 17 || $Transaction_type == 7 || $Transaction_type == 13 || $Transaction_type == 18 || $Transaction_type == 22)
						{ ?>
							<td><?php echo $Topup_amount; ?></td>
				<?php	}
						else
						{ ?>
							<td><?php echo $Recived_point; ?></td>
				<?php	} ?>
					</tr>
					
					<tr>
						<th><?php echo $Company_details->Currency_name; ?> Used</th>
				<?php	if($Transaction_type == 8) 
						{ ?>
						 <td><?php echo $Transfer_points; ?></td>
				<?php	}
						else
						{ ?>
							<td><?php echo $Redeem_points; ?></td>
				<?php	} ?>
					</tr>
					<?php
						if($Transaction_type == 10 && $Delivery_method==29)
						{ ?>
						<tr>
							<th>Shipping <?php echo $Company_details->Currency_name; ?> </th>
							<td><?php echo $Shipping_points; ?></td>
						</tr> 
				<?php	}
					?> 
					<?php if($Transaction_type == 14) {  ?>
					<tr>
						<th>Expired <?php echo $Company_details->Currency_name; ?> </th>
						<td><?php echo $Expired_points; ?></td>
					</tr>
					<?php } ?>
					
					<?php if($Transaction_type == 2){ ?>
					<tr>
						<th>Category</th>
						<td><strong><?php echo $Item_category_name; ?></strong></td>
					</tr>
					<?php } ?>
						<?php if($Transaction_type !=8 && $Transaction_type !=17 && $Transaction_type !=7 && $Transaction_type !=13&& $Transaction_type !=18 && $Transaction_type !=14 && $Transaction_type !=22) { ?>
					<?php	if($Transaction_type==12)
							{ ?>
								<tr>
									<th> Shipping Cost </th>
									<td> <?php echo $Shipping_cost; ?> </td>
								</tr>
							
					<?php 	} ?>
					<tr>
						<th> <?php if($Transaction_type == 1)
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
						</th>
						<td>
							<strong>
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
							</strong>
						</td>
					</tr>	
				<?php } ?>					
					<?php if($Transaction_type == 2 || $Transaction_type == 4){ ?>
					<tr>
						<th>
							<?php
							if($Transaction_type == 2){ echo "Redeemed ".$Company_details->Currency_name; }
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
					<?php if($Payment_type_id != 1 && $Transaction_type == 2 && $Bank_name != ''){?>
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
					
					
					<?php  if($Transaction_type == 2){ ?>
					<tr>
						<th><?php echo $Company_details->Currency_name; ?> Gained at Merchant</th>
						<td>
							<strong>
								<?php 
								echo $Loyalty_pts;
								?>
							</strong>
						</td>
					</tr>
					<tr>
						<th><?php echo $Company_details->Currency_name; ?> Gained due to Coalition </th>
						<td>
							<strong>
								<?php 
								echo round($Coalition_Loyalty_pts);
								?>
							</strong>
						</td>
					</tr>
					<?php } ?>
					<tr>
					<th>Merchant</th>
					<td><?php echo $Seller_name; ?></td>
					</tr>
					<tr>
						<th>Remark</th>
						<td>
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
		</div>
		<div class="modal-footer">
			<button type="button" id="print_modal" onclick="window.print();" class="btn btn-primary">Print</button>
			<button type="button" id="close_modal" class="btn btn-primary">Cancel</button>
		</div>

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
