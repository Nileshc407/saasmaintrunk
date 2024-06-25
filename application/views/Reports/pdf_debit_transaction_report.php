<?php if($Debit_trans_details != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Debit Transaction Report - <?php if($Report_type == 0) { echo " Details"; } else { echo " Summary";} ?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<?php 
				if($Report_type==0)
				{ ?>
				<tr style="background-color: #D9EDF7;">
					<th style="text-align:center">Transaction Date</th>
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center">Member Name</th>
					<th style="text-align:center">Membership ID</th>
					<th style="text-align:center">Bill No.</th>
					<th style="text-align:center">Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Debited <?php echo $Company_details->Currency_name; ?></th>
					<th style="text-align:center">Credited Redeem <?php echo $Company_details->Currency_name; ?></th>
					<th style="text-align:center">Remarks</th>
				</tr>
		<?php 	}
				else if($Report_type==1)
				{  ?>
				<tr style="background-color: #D9EDF7;">
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center">Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Debited <?php echo $Company_details->Currency_name; ?></th>
					<th style="text-align:center">Credited Redeem <?php echo $Company_details->Currency_name; ?></th>
				</tr>
		<?php	 }   ?>
			</thead>	
			<tbody>
		<?php
				$lv_Merchant_id=0;
				foreach($Debit_trans_details as $row)
				{	
					
					$Merchant_id=$row->Seller_id;
					$sellerName=$row->Merchant_name;
					if($lv_Merchant_id!=$Merchant_id && $Report_type==1)//&& $report_type!=2
					{
						echo "<tr><td colspan='16' style='background-color:#D9EDF7; color:blue;'>".$sellerName." </td></tr>";
					}  
					if($Report_type==0)
					{
				?>					
                    <tr>	
									
						<td style="text-align:center"><?php echo $row->Trans_date; ?></td>
						<td style="text-align:center"><?php echo $row->Merchant_name; ?></td>
						<td style="text-align:center"><?php echo $row->Member_name; ?></td>
						<td style="text-align:center"><?php echo $row->Membership_Id; ?></td>
						<td style="text-align:center"><?php echo $row->Bill_no; ?></td>
						<td style="text-align:center"><?php echo $row->Cancellation_amount; ?></td>
						<td style="text-align:center"><?php echo $row->Debited_points; ?></td>
						<td style="text-align:center"><?php echo $row->Credited_redeem_points; ?></td>
						<td style="text-align:center"><?php echo $row->Remarks; ?></td>
					</tr>
				<?php
				    }
					else if($Report_type==1)
					{ ?>
					<tr>	
						<td style="text-align:center"><?php echo $row->Merchant_name;?></td>		<td style="text-align:center"><?php echo $row->Total_cancellation_amount; ?></td>
						<td style="text-align:center"><?php echo $row->Total_debited_points; ?></td>
						<td style="text-align:center"><?php echo $row->Total_credited_points; ?></td>
					</tr>
			<?php	}
					
				}
				$lv_Merchant_id=$Merchant_id; 
					?>		
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>