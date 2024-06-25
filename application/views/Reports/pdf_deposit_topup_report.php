<?php if($Seller_report_details != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h2 style="text-align:center">Deposit/Merchant Topup Report</h2>
		<h4 style="text-align:center">Report Date : <?php echo $Report_date; ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<tr style="background-color: #D9EDF7;">
				
				<th style="text-align:center">Company Name</th>
				<th style="text-align:center">Merchant Name</th>
				<th style="text-align:center">Transaction Date</th>
				<th style="text-align:center">Exception Transaction</th>
				<th style="text-align:center">Transaction Type</th>
				<th style="text-align:center">Topup Amount</th>

			</tr>
			</thead>
			
			<tbody>
			<?php
			foreach($Seller_report_details as $row)
			{
			?>					
				<tr>
					<td><?php echo $row->Company_name; ?></td>
					<td><?php echo $row->Merchant_name; ?></td>
					<td><?php echo date("Y-m-d",strtotime($row->Transaction_date));?></td>
					<td><?php echo  $row->Exception_transaction; ?> </td>
					<td><?php echo $row->Transaction_type; ?> </td>
					<td><?php echo $row->Topup_amount;?></td>				
				</tr>
			<?php
			}
			?>			
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>