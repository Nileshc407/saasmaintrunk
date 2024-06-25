<?php if(count($Trans_Records) != 0) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Stamp Report</h2>
		
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>Member Name</th>
							<th>Voucher No.</th>
							<th>Issued Outlet</th>
							<th>Issued Date</th>
							<th>Valid Till</th>
							<th>Free Item Name</th>
							<th>Issued Qty</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Status</th>
							<th>Used Outlet</th>
							<th>Used Date</th>
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if(count($Trans_Records) > 0)
						{
							 
							foreach($Trans_Records as $row)
							{
								
								
								echo "<tr>";
								echo "<td>".$row->Issued_to."</td>";
								echo "<td>".$row->Voucher_no."</td>";
								echo "<td>".$row->Issud_Outlet."</td>";

								
								echo "<td>".date('Y-m-d',strtotime($row->Issued_on))."</td>";
								echo "<td>".date('Y-m-d',strtotime($row->Valid_till))."</td>";
								echo "<td>".$row->Item_name."</td>";
								echo "<td>".$row->Quantity."</td>";
								echo "<td>".number_format(round($row->Cost_price),2)."</td>";
								echo "<td>".$row->Status."</td>";
								
								echo "<td>".$row->Used_Outlet."</td>";
								echo "<td>".$row->Used_date."</td>";

								echo "</tr>";
								
							}
							
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>