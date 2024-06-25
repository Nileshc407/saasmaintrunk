<?php if(count($Trans_Records) != 0) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Gift Card Transactions Report</h2>
		
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>Membership ID</th>
							<th>Member Name</th>
							<th>Gift Card No.</th>
							<th>Purchase Date</th>
							<th>Purchase Amt. <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Status</th>
							<!--<th>Used at Business/Merchant</th>-->
							<th>Used at Outlet</th>
							<th>Used Date</th>
							<th>Send To</th>
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if(count($Trans_Records) > 0)
						{
							 
							foreach($Trans_Records as $row)
							{
								
								
								echo "<tr>";
								echo "<td>".$row->Membership_id."</td>";
								echo "<td>".$row->Member_name."</td>";
								echo "<td>".$row->Gift_card_no."</td>";
								echo "<td>".$row->Purchase_date."</td>";
								echo "<td>".number_format(round($row->Purchase_amount),2)."</td>";
								echo "<td>".$row->Status."</td>";
								echo "<td>".$row->Used_Outlet."</td>";
								echo "<td>".$row->Used_date."</td>";
								echo "<td>".$row->Send_to_user."</td>";

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