<?php if($liability_report != NULL || $liability_report1 != NULL || $liability_report2 != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Company <?php echo $Company_details->Currency_name; ?> Liability Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
	<?php
		if($liability_report != NULL) 
		{ ?>		
			<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" width="100%">
				<thead>
				<tr style="background-color: #D9EDF7;">		
					<th align="left" colspan="3" style='color:blue;'>ISSUED <?php echo $Company_details->Currency_name; ?></th>			
				</tr>
				<tr style="background-color: #D9EDF7;">		
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center"><?php echo $Company_details->Currency_name; ?> Issued</th>
					<th style="text-align:center">Equivalent (<?php echo $Symbol_of_currency; ?>) Excluding Tax</th>					
				</tr>
				</thead>				
				<tbody>
			<?php
				foreach($liability_report as $row)
				{	?>								
                    <tr>	
						<td style="text-align:center"><?php echo $row->Merchant_name; ?></td>		<td style="text-align:center"><?php echo $row->Total_points_issued; ?></td>	<td style="text-align:center"><?php echo $row->EquivalentAED; ?></td>	
					</tr>
		<?php   } ?>
				</tbody> 
			</table>
	
		<?php 
		} 
		if($liability_report1 != NULL || $liability_report2 != NULL) 
		{ ?>
			<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" width="100%">
				<thead>
				<tr style="background-color: #D9EDF7;">		
					<th align="left" colspan="4" style='color:blue;'>USED <?php echo $Company_details->Currency_name; ?></th>					
				</tr>
				<?php if($liability_report1 != NULL) { ?>
				<tr>		
					<th align="left" colspan="4" style='color:red;'>FROM PUBLISHER</th>	
				</tr>
				<tr style="background-color: #D9EDF7;">		
					<th style="text-align:center">Publisher Name</th>
					<th style="text-align:center">Pending</th>
					<th style="text-align:center">Approved</th>					
					<th style="text-align:center">Cancelled</th>					
				</tr>
				<?php } ?>
				</thead>				
				<tbody>
			<?php 
			
				foreach($liability_report1 as $row)
				{	
					if($row->Beneficiary_company!=0) { ?>								
                    <tr>	
						<td style="text-align:center"><?php echo $row->Publisher_name; ?></td>		
						<td style="text-align:center"><?php echo $row->Pending_Redeem_points; ?></td>		
						<td style="text-align:center"><?php echo $row->Approved_Redeem_points; ?></td>	
						<td style="text-align:center"><?php echo $row->Cancelled_Redeem_points; ?></td>			
					</tr>
		<?php   	}  
				} ?>
				</tbody> 
			</table>
		
<?php   } 
		if($liability_report2 != NULL) 
		{ ?>		
			<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" width="100%">
				<thead>
				<tr>		
					<th align="left" colspan="3" style='color:red;'>FROM CATALOGUE</th>	
				</tr>
				<tr style="background-color: #D9EDF7;">		
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center">Ordered <span style="color:red; font-size: 9px;">(Ordered/Shipped/Issued/)</span></th>
					<th style="text-align:center">Fulfilled <span style="color:red; font-size: 9px;">(Used/Delivered)</span></th>									
				</tr>
				</thead>				
				<tbody>
			<?php 
				foreach($liability_report2 as $row)
				{	
					if($row->Merchant_id!=0)
					{ ?>								
						<tr>	
							<td style="text-align:center"><?php echo $row->Merchant_name; ?></td>	<td style="text-align:center"><?php echo $row->Ordered_Redeem_points; ?></td>	
							<td style="text-align:center"><?php echo $row->Fulfilled_Redeem_points; ?></td>
						</tr>
			<?php   } 
				}  ?>
				</tbody> 
			</table>		
<?php   } 
		if($liability_report3 != NULL) { ?>
		
			<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" width="100%">
				<thead>
				<tr style="background-color: #D9EDF7;">		
					<th align="left" colspan="3" style='color:blue;'>SETTLEMENT</th>					
				</tr>
				<tr>		
					<th align="left" colspan="3" style='color:red;'>MERCHANTS</th>	
				</tr>
				<tr style="background-color: #D9EDF7;">		
					<th style="text-align:center">Merchant Name</th>
					<th style="text-align:center">Invoiced (<?php echo $Symbol_of_currency; ?>) Including Tax</th>
					<th style="text-align:center">Settled (<?php echo $Symbol_of_currency; ?>)</th>									
				</tr>
				</thead>				
				<tbody>
			<?php 
				foreach($liability_report3 as $row)
				{	
					if($row->Merchant_id!=0)
					{ ?>								
						<tr>	
							<td style="text-align:center"><?php echo $row->Merchant_name; ?></td>	<td style="text-align:center"><?php echo $row->MInvoiced_AED; ?></td>	<td style="text-align:center"><?php echo $row->MSettled_AED; ?></td>
						</tr>
			<?php   } 
				}  ?>
				</tbody> 
			</table>
	
		<?php } 
		if($liability_report4 != NULL) { ?>
		
			<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" width="100%">
				<thead>
				<tr style="background-color: #D9EDF7;">		
					<th align="left" colspan="3" style='color:red;'>PUBLISHERS</th>	
				</tr>
				<tr>		
					<th style="text-align:center">Publisher Name</th>
					<th style="text-align:center">Invoiced (<?php echo $Symbol_of_currency; ?>) Including Tax</th>
					<th style="text-align:center">Settled (<?php echo $Symbol_of_currency; ?>)</th>									
				</tr>
				</thead>				
				<tbody>
			<?php 
				foreach($liability_report4 as $row)
				{	
					if($row->Publisher_id!=0)
					{ ?>								
						<tr>	
							<td style="text-align:center"><?php echo $row->Publisher_name1; ?></td>	<td style="text-align:center"><?php echo $row->PInvoiced_AED; ?></td>	<td style="text-align:center"><?php echo $row->PSettled_AED; ?></td>
						</tr>
			<?php   } 
				}  ?>
				</tbody> 
			</table>
		
		<?php } ?>
	</div>
</div>
<?php } ?>