<?php if($Trans_Records != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Items Sales Report </h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($start_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
				<tr>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>Category</th>
					<th>Qty Sold </th>
					
					<th>Value Sold <?php echo "($Symbol_currency)"; ?></th>
					
				<!--	<th>Total Redeemed  <?php //echo $Company_details->Currency_name; ?></th>-->
				<!--	<th>Total Gained  <?php //echo $Company_details->Currency_name; ?></th>-->
					<th>Business/Merchant</th>		
					<th>Outlet</th>		
					<th>Channel</th>		
	
				</tr>
				
			
			</thead>	
			<tbody>
				<?php
					$ci_object = &get_instance(); 
				if($Trans_Records != NULL)
				{

					foreach($Trans_Records as $row)
					{
						if($row->Channel == 12)
						{
							$TransChannel = "Online";
						}
						
						if($row->Channel == 2)
						{
							$TransChannel = "POS";
						}
						
						if($row->Channel == 29)
						{
							$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
							$TransChannel = $Channel_name->Beneficiary_company_name;
						}
						
						
						?>
									<tr>
										<td><?php echo $row->Item_code;?></td>
										<td><?php echo $row->Item_name;?></td>
										<td><?php echo $row->Category;?></td>
										<td><?php echo $row->Qty_sold;?></td>
										<td><?php echo number_format(round($row->Value_sold),2); ?> </td>
										<!--<td><?php //echo ceil($row->TotalRedeemPoints);?></td>
										<td><?php //echo round($row->TotalLoyaltyPoints);?></td>-->
										<td><?php echo $brand_name;?></td>
										<td><?php echo $row->Outlet;?></td>
										<td><?php echo $TransChannel;?></td>
									</tr>
					<?php		
					}
							
					
				}				
				
		
				?>		
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>