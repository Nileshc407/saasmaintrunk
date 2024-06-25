
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center"><?php echo $Company_details->Currency_name; ?> Usage Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" align="center">
			<thead>
			<tr style="background-color: #D9EDF7;">
				<?php if($Report_type == 0) { ?><th style="text-align:center">Transaction Date</th><?php } ?>
				<?php if($Report_type == 0) { ?><th class="text-center">Publishers Name</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Member Name</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Membership ID</th><?php } ?>
				<?php if($Report_type == 0) { ?><th style="text-align:center">Bill No.</th><?php } ?>
			<!--<th style="text-align:center">Transaction Type</th>-->
			
				<?php if($Report_type == 1) { ?>
					<th style="text-align:center">Status</th>
				<?php } ?>
				
				<th style="text-align:center"><?php if($Report_type == 0) { echo "Purchase Miles/Points"; }else { echo "Total Purchase Miles/Points"; } ?></th>
				
				<th class="text-center"><?php if($Report_type == 0) { echo "Used ".$Company_details->Currency_name; }else { echo "Total Used ".$Company_details->Currency_name; } ?></th>
						
			<?php if($Report_type == 0) { ?>
				<th style="text-align:center">Status</th>
			<?php	} ?>
			
				<?php if($Report_type == 0) { echo '<th class="text-center">Remarks </th>'; } ?>			
			</tr>
			</thead>	
			<tbody>
			<?php 
			if($Seller_report_details != NULL) { 
						
						$lv_Merchant_id=0;
						
						foreach($Seller_report_details as $row)
						{
							
							$Publishers_id=$row->Publishers_id;
							
							$PublishersName=$row->PublishersName;
							if($lv_Merchant_id!=$Publishers_id && $Report_type==1)
							{
								echo "<tr><td colspan='14' style='color:blue;'>".$PublishersName." </td></tr>";
							}					
							
							if($row->Purchase_miles==0 )
							{
								$row->Purchase_miles="-";
							}
							if($row->Used_points==0)
							{
								$row->Used_points="-";
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
								<?php if($Report_type == 0) { ?>
								
									<td style="text-align:center;"><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td>
									<td><?php echo $PublishersName;?></td>
									<td><?php echo $row->Member_name;?></td>
									<td><?php echo $row->Membership_ID; ?></td>
									<td><?php echo $Bill_no2; ?></td>
									<td class="text-center"><?php echo $row->Remarks; ?></td>
								
								<?php } ?>								
								<td style="text-align:center"><?php echo $row->status; ?></td>					
								<td style="text-align:center"><?php echo $row->Purchase_miles; ?></td>								
								<td style="text-align:center"><?php echo $row->Used_points; ?></td>							
								
					
										
							</tr>
						<?php
							$lv_Merchant_id=$Publishers_id; 
						}		
			} else {
				?>
				<tr>
				<?php if($Report_type == 0) { ?>
					<td colspan="9" style="text-align:center"><p> No Record found(s)</p></td>
				<?php } else { ?>
					<td colspan="3" style="text-align:center"><p> No Record found(s)</p></td>
				<?php } ?>
						
				</tr>
		<?php } ?>			
			</tbody> 
		</table>
	</div>
</div>
