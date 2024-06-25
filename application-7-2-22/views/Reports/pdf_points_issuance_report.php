<?php if($Seller_report_details != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center"><?php echo $Company_details->Currency_name; ?> Issuance Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<tr style="background-color: #D9EDF7;">
				<?php if($Report_type == 0) { ?><th style="text-align:center">Transaction Date</th><?php } ?>
				<?php if($Report_type == 0) { ?><th class="text-center">Merchant Name</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Member Name</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Membership ID</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Bill No.</th><?php } ?>
				<th style="text-align:center">Transaction Type</th>
				<th style="text-align:center"><?php if($Report_type == 0) { echo "Bonus ".$Company_details->Currency_name." Issued"; }else { echo "Total Bonus ".$Company_details->Currency_name." Issued"; } ?></th>
				<th style="text-align:center"><?php if($Report_type == 0) { echo "Purchase Amount (".$Symbol_currency." )"; }else { echo "Total Purchase Amount (".$Symbol_currency." )"; } ?></th>
				<th class="text-center"><?php if($Report_type == 0) { echo $Company_details->Currency_name." Issued"; }else { echo "Total ".$Company_details->Currency_name." Issued"; } ?></th>
				<th class="text-center"><?php if($Report_type == 0) { echo "Redeemed ".$Company_details->Currency_name; }else { echo "Total Redeemed ".$Company_details->Currency_name; } ?></th>
				
				<?php if($Report_type == 0) { echo '<th class="text-center">Remarks </th>'; } ?>			
			</tr>
			</thead>	
			<tbody>
		<?php
			
			$lv_Merchant_id=0;
			
			foreach($Seller_report_details as $row)
			{
				$Merchant_id=$row->Merchant_id;
				$sellerName=$row->Merchant_name;
				if($lv_Merchant_id!=$Merchant_id && $Report_type==1)
				{
					echo "<tr><td colspan='14'   style='color:blue;'>".$sellerName." </td></tr>";
				}					
				if($row->Bonus_points==0 )
				{
					$row->Bonus_points="-";
				}
				if($row->Purchase_amt==0 )
				{
					$Purchase_amt="-";
				}
				else
				{
					$Purchase_amt=number_format($row->Purchase_amt, 2);
				}
				if($row->Reedem_pts==0)
				{
					$row->Reedem_pts="-";
				}
				
				if($row->loyalty_pts_gain==0)
				{
					$row->loyalty_pts_gain="-";
				}
				
				if($row->Manual_billno=="-")
				{
					$Bill_no2=$row->Bill_no;
				}
				else
				{
					$Bill_no2=$row->Manual_billno;
				}
			?>					
				<tr>
					<?php if($Report_type == 0) { ?><td style="text-align:center;"><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td><?php } ?>	
					<?php if($Report_type == 0) { ?><td><?php echo $sellerName;?></td><?php } 
					if($Report_type == 0) { ?><td><?php echo $row->Member_name;?></td><?php } 
					if($Report_type == 0) { ?><td><?php echo $row->Membership_ID; ?></td><?php } 
					if($Report_type == 0) { ?><td><?php echo $Bill_no2; ?></td><?php } ?>
					<td><?php echo $row->Trans_type;?></td>
					<td style="text-align:center"><?php echo $row->Bonus_points; ?></td>
					<td style="text-align:center"><?php echo $Purchase_amt; ?></td>
					<td class="text-center"><?php echo $row->loyalty_pts_gain; ?></td>
					<td style="text-align:center"><?php echo $row->Reedem_pts; ?></td>
					<?php if($Report_type == 0) { ?>
					<td class="text-center"><?php echo $row->Remarks; ?></td><?php } ?>					
				</tr>
			<?php
				$lv_Merchant_id=$Merchant_id; 
			}		
			?>			
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>