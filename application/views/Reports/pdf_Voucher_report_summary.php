<?php if(count($Trans_Records) != 0) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Voucher Summary Report</h2>
		
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>Issued To</th>
							<th>No. of Vouchers Issued</th>
							<th>No. of Vouchers Used</th>
							<th>No. of Value Vouchers Issued</th>
							<th>Value of Vouchers Used <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Value of Available <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>No. of % Vouchers Issued</th>
							<th>Total % Vouchers Used</th>
							<th>Total % Vouchers Unused</th>
					
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
								echo "<td>".$row->Total_Issued_vouchers."</td>";
								echo "<td>".$row->Total_Used_vouchers."</td>";
								echo "<td>".$row->Total_Issued_Value_Vouchers."</td>";
								echo "<td>".number_format(round($row->Used_Value_Vouchers),2)."</td>";
								echo "<td>".number_format(round($row->Available_Value_Vouchers),2)."</td>";
								echo "<td>".$row->Total_Issued_Percenatage_Vouchers."</td>";
								echo "<td>".$row->Used_Percentage_Vouchers."</td>";
								echo "<td>".$row->Unused_Percentage_Vouchers."</td>";

								echo "</tr>";
								
							}
							
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>?>