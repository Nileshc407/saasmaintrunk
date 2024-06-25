
	<div class="element-wrapper">
		<div class="element-box">
			<h5 class="form-header"> Transaction Details</h5>				
			<div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Receipt</th>
							<th>Transaction Type</th>
							<th>Member Name</th>
							<th>Membership ID</th>
							<th>Purchase Amount</th>
							<th>Redeem <?php echo $Company_details->Currency_name; ?> </th>
							<th>Gained <?php echo $Company_details->Currency_name; ?>/Debit <?php echo $Company_details->Currency_name; ?> </th>
							<?php if($Company_details->Coalition==1) { ?>
							<th>Coalition Gained <?php echo $Company_details->Currency_name; ?>/Debit <?php echo $Company_details->Currency_name; ?> </th>
							<?php } ?>
							<th>Transaction Date</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Receipt</th>
							<th>Transaction Type</th>
							<th>Member Name</th>
							<th>Membership ID</th>
							<th>Purchase Amount</th>
							<th>Redeem <?php echo $Company_details->Currency_name; ?> </th>
							<th>Gained <?php echo $Company_details->Currency_name; ?>/Debit <?php echo $Company_details->Currency_name; ?> </th>
							<?php if($Company_details->Coalition==1) { ?>
							<th>Coalition Gained <?php echo $Company_details->Currency_name; ?>/Debit <?php echo $Company_details->Currency_name; ?> </th>
							<?php } ?>
							<th>Transaction Date</th>
						</tr>
					</tfoot>
					
					<tbody>
					<?php
					if($result != NULL)
					{
						
						foreach($result	as $row)
						{
							if($row['Trans_type']==26)
							{
							  $Cancelle[]=$row['Purchase_amount'];
							}
							else
							{
								$Cancelle[]=0;
							}
							?>
						
						<tr> <?php
							if($row['Trans_type']==2)
							{
								$Purchase_amt[]=$row['Purchase_amount'];
								?>
							<td>
							<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details('<?php echo $row['Bill_no']; ?>',<?php echo $row['Seller']; ?>,<?php echo $row['Trans_id']; ?>);" title="Receipt">
								<i class="os-icon os-icon-ui-49" ></i>
							</a>								
							</td>
						<?php	} else { ?>
							<td class="text-center"> &nbsp; </td>						
						<?php	} ?>
							<td><?php echo $row['TransType']; ?></td>
							<td><?php echo $row['First_name'].' '.$row['Last_name']; ?></td>
							<td><?php echo $row['Card_id']; ?></td>
							<td><?php echo $row['Purchase_amount']; ?></td>
							<td><?php echo $row['Redeem_points']; ?></td>
							<td><?php echo $row['Loyalty_pts']; ?></td>
							<?php if($Company_details->Coalition==1) { ?>
							<td><?php echo $row['Coalition_Loyalty_pts']; ?></td>
							<?php } ?>
							<td><?php echo date('Y-m-d H:i:s',strtotime($row['Trans_date'])); ?></td>
				
						</tr>
						<?php
							
						}
						$total_cancelle_amt = array_sum($Cancelle);
						$total_Purchase_amt = array_sum($Purchase_amt);
						
						$total_remaining_cancelle_amt = ($total_Purchase_amt)-($total_cancelle_amt);
					}
					?>	
					</tbody> 
				</table>
			</div>
		</div>
	</div>
		<input type="hidden" name="total_cancelle_amt" id="total_cancelle_amt" value="<?php echo $total_cancelle_amt; ?> "class="form-control"  />	

<script>
var Amount_Cancellation=<?php echo $total_remaining_cancelle_amt ;?>//parseFloat(json['Purchase_amount'])-parseFloat(10);
$('#Remaining_Amount_Cancellation').val(Amount_Cancellation);
</script>