<?php if($Seller_billing_details != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Merchant Debit Billing & Settlement Report - <?php if($Report_type == 0) { echo " Details"; } else { echo " Summary";} ?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<?php 
				if($Report_type==0)
				{ ?>
				<tr style="background-color: #D9EDF7;">
					<th style="text-align:center">Creation Date/Settlement Date</th>
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center">Invoice No.</th>
					<th style="text-align:center"><?php echo $Company_details->Currency_name; ?> Debited</th>
					<th style="text-align:center">Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>
					
					<th style="text-align:center">Invoice Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Settlement Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Paid Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Settlement Status</th>
					<th style="text-align:center">Payment Type</th>
					<th style="text-align:center">Bank Name</th>
					<th style="text-align:center">Branch Name</th>
					<th style="text-align:center">Credit/Cheque No.</th>
				</tr>
		<?php 	}
				else if($Report_type==1)
				{  ?>
				<tr style="background-color: #D9EDF7;">
					<th style="text-align:center">Creation Date</th>
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center">Invoice No.</th>
					<th style="text-align:center"><?php echo $Company_details->Currency_name; ?> Debited</th>
					<th style="text-align:center">Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>
				
					<th style="text-align:center">Invoice Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Settlement Amount (<?php echo $Symbol_of_currency ?>)</th>
					<th style="text-align:center">Settlement Status</th>
				</tr>
		<?php	 }   ?>
			</thead>	
			<tbody>
		<?php
				$lv_Merchant_id=0;
				foreach($Seller_billing_details as $row)
				{	
					
					$Merchant_id=$row->Seller_id;
					$sellerName=$row->Merchant_name;
					if($lv_Merchant_id!=$Merchant_id)//&& $report_type!=2
					{
						echo "<tr><td colspan='16' style='background-color:#D9EDF7; color:blue;'>".$sellerName." - Invoice No. - ".$row->Bill_no." </td></tr>";
					}  
					if($Report_type==0)
					{
						if($row->Bill_Creation_date!=NULL)
						{
							$TransDate=$row->Bill_Creation_date;
						}
						else if($row->Settlement_date!=NULL)
						{
							$TransDate=$row->Settlement_date;
						}
				?>					
                    <tr>	
						<td style="text-align:center"><?php echo $TransDate;?></td>			
						<td style="text-align:center"><?php echo $row->Merchant_name; ?></td>
						<td style="text-align:center"><?php echo $row->Bill_no; ?></td>
						<td style="text-align:center"><?php echo $row->Point_debited; ?></td>
						<td style="text-align:center"><?php echo $row->Cancellation_amount; ?></td>
						
						<td style="text-align:center"><?php echo $row->Bill_amount; ?></td>
						<td style="text-align:center"><?php echo $row->Settlement_amount; ?></td>
						<td style="text-align:center"><?php echo $row->Paid_amount; ?></td>
						<td style="text-align:center" <?php if($row->Settlement_flag=='Settled') { ?> style="color:green;"<?php } else if($row->Settlement_flag=='Pending') { ?> style="color:red;" <?php } ?>><?php echo $row->Settlement_flag; ?></td>
						<td style="text-align:center"><?php echo $row->Pay_type; ?></td>
						<td style="text-align:center"><?php echo $row->Bank_name; ?></td>
						<td style="text-align:center"><?php echo $row->Branch_name; ?></td>
						<td style="text-align:center"><?php echo $row->Credit_Cheque_number; ?></td>
					</tr>
				<?php
				    }
					else if($Report_type==1)
					{ ?>
						<tr>	
						<td style="text-align:center"><?php echo $row->Bill_Creation_date;?></td>			
						<td style="text-align:center"><?php echo $row->Merchant_name; ?></td>
						<td style="text-align:center"><?php echo $row->Bill_no; ?></td>
						<td style="text-align:center"><?php echo $row->Point_debited; ?></td>
						<td style="text-align:center"><?php echo $row->Cancellation_amount; ?></td>
						
						<td style="text-align:center"><?php echo $row->Bill_amount; ?></td>
						<td style="text-align:center"><?php echo $row->Settlement_amount; ?></td>
						<td style="text-align:center" <?php if($row->Settlement_flag=='Settled') { ?> style="color:green;"<?php } else if($row->Settlement_flag=='Pending') { ?> style="color:red;" <?php } ?>><?php echo $row->Settlement_flag; ?></td>
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