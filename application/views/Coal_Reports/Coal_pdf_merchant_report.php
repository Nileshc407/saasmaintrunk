<?php if($Seller_report_details != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Outlet Transaction Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<tr style="background-color: #D9EDF7;">
				<?php if($Report_type == 0) { ?><th style="text-align:center">Transaction Date</th><?php } ?>
				<th style="text-align:center">Transaction Type</th>
				<th class="text-center">Outlet</th>
				
				<?php if($Report_type == 0) { ?><th>EHP_Order_No</th><?php } ?>
				<?php if($Report_type == 0) { ?><th>POS Bill No.</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Membership ID/Gift Card No.</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Member Name</th><?php } ?>
				
                <!-- <?php if($Report_type == 0) { ?><th class="text-center">Walk-in Member Yes / No</th><?php } ?>-->
				<th style="text-align:center"><?php if($Report_type == 0) { echo "Purchase Amount (".$Symbol_currency." ) "; }else { echo "Total Purchase Amount (".$Symbol_currency." ) "; } ?></th>
				
				<th style="text-align:center"><?php if($Report_type == 0) { echo "Bonus ".$Company_details->Currency_name." Issued"; }else { echo "Total Bonus ".$Company_details->Currency_name; } ?></th>
				
				<th class="text-center"><?php if($Report_type == 0) { echo "Redeemed ".$Company_details->Currency_name; }else { echo "Total Redeemed ".$Company_details->Currency_name; } ?></th> 
				<?php if($Report_type == 0) { ?><th class="text-center">Voucher Number</th><?php } ?>
				
				<?php if($Report_type == 1) { echo "<th>Total Voucher Redeemed</th>"; } ?>
									
				<?php if($Report_type == 1) { echo "<th>Total Voucher Amt (".$Symbol_currency.") </th>"; } ?>
				<?php //if($Report_type == 0) { echo '<th class="text-center">Remarks </th>'; } ?>		
			</tr>
			</thead>
			
			<tbody>
			<?php
			$lv_Merchant_id=0;
			// var_dump($Seller_report_details);
			foreach($Seller_report_details as $row)
			{
				$Merchant_id=$row->Merchant_id;
				$sellerName=$row->Outlet;
				if($lv_Merchant_id!=$Merchant_id && $Report_type==1)//&& $report_type!=2
				{
					echo "<tr><td colspan='14'   style='color:blue;'>".$sellerName." </td></tr>";
				}					
				if($row->Bonus_points==0 )
				{
					$row->Bonus_points="-";
				}
				if($row->Purchase_amt==0 )
				{
					$row->Purchase_amt="-";
				}
				if($row->reedem_pt==0)
				{
					$row->reedem_pt="-";
				}
				if($row->balance_to_pay==0)
				{
					$row->balance_to_pay="-";
				}
				if($row->loyalty_pts_gain==0)
				{
					$row->loyalty_pts_gain="-";
				}
				if($row->Coalition_Points_Gain==0)
				{
					$row->Coalition_Points_Gain="-";
				}
					/* if($row->POS_bill_no=="")
					{
						$Bill_no=$row->EHP_Order_no;
					}
					else
					{
						$Bill_no=$row->POS_bill_no;
					} */
			?>					
				<tr>
					<?php if($Report_type == 0) { ?><td style="text-align:center;"><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td><?php } ?>
					<td><?php echo $row->Trans_type;?></td>					
					<td><?php echo $sellerName;?></td>
					<?PHP if($Report_type == 0) 
							{ ?>
								<td><?php echo $row->EHP_Order_no; ?></td>
					  <?php }
							if($Report_type == 0) 
							{ ?>
								<td><?php echo $row->POS_bill_no; ?></td>
					  <?php }
					 if($Report_type == 0) { ?><td><?php echo $row->Membership_ID; ?></td><?php } ?>
					<?php if($Report_type == 0) { ?><td><?php echo $row->Member_name;?></td><?php } ?>
                                        <!--<?php if($Report_type == 0) { ?><td class="text-center"><?php echo $row->Walkin_customer; ?></td><?php } ?>-->
					 
					 <td style="text-align:center"><?php echo number_format($row->Purchase_amt,2); ?></td>
					 
					<td style="text-align:center"><?php echo $row->Bonus_points; ?></td>
					
					<td style="text-align:center"><?php echo $row->Reedem_pts; ?></td>
				<?php 
				 if($Report_type == 0) { ?>	<td style="text-align:center"><?php echo $row->Voucher_no; ?></td>
					 <?php } ?>
					 
					<?php if($Report_type == 1) {?>	<th><?php echo $row->Voucher_redeemed; ?></th> 
					<?php }
							if($Report_type == 1) { ?><th><?php echo number_format($row->Voucher_amount,2);?></th> 
					<?php 
							}
					?>
					<!--<?php //if($Report_type == 0) { ?><td class="text-center"><?php //echo $row->Remarks; ?></td><?php //} ?>	-->				
				</tr>
			<?php
				$lv_Merchant_id=$Merchant_id; 
			}
			// die;
			?>			
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>
