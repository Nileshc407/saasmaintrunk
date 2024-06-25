<?php if(count($Trans_Records) != 0) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Voucher Report</h2>
		
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>Voucher No.</th>
							<th>Issued To</th>
							<th>Issued On</th>
							<th>Type</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Percentage</th>
							<th>Status</th>
							<th>Used On</th>
							<th>Used Outlet</th>
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if(count($Trans_Records) > 0)
						{
							 
							foreach($Trans_Records as $row)
							{
								
								
								echo "<tr>";
								echo "<td>".$row->Voucher_no."</td>";
								echo "<td>".$row->Issued_to."</td>";
								echo "<td>".$row->Issued_on."</td>";
								echo "<td>".$row->Type."</td>";
								echo "<td>".number_format(round($row->Value),2)."</td>";
								echo "<td>".$row->Discount_percentage."</td>";
								echo "<td>".$row->Status."</td>";
								echo "<td>".$row->Used_date."</td>";
								echo "<td>".$row->Used_Outlet."</td>";

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