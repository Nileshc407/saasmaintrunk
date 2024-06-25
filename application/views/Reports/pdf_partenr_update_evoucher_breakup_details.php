<?php if($Trans_Records != NULL) { 

//error_reporting(0); 

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Merchandize Partner Offer Status Details</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
		
	</div> 
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("Y-m-d"); ?></h5>
		</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
				<thead>
						
					<tr>
						<th>Member Name</th>
						<th>Partner Name</th>
						<th>Item Name</th>
						<th>Voucher No</th>
						<th>Used Date	</th>
						<th>Issued Quantity</th>					
						<th>Used Quantity</th>					
						<th>Balance Quantity</th>					
					</tr>
						
						</thead>
						
						<tbody>
						<?php
						$todays = date("Y-m-d");
						if($Trans_Records != NULL)
						{
							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Last_name;
								echo "<tr>";
								echo "<td>".$Full_name."</td>";
								echo "<td>".$row->Partner_name."</td>";
								echo "<td>".$row->Merchandize_item_name."</td>";
								echo "<td>".$row->Voucher_no."</td>";
								echo "<td>".$row->Update_date."</td>";
								echo "<td>".$row->Quantity."</td>";
								echo "<td>".$row->Updated_quantity."</td>";
								echo "<td>".$row->Quantity_balance."</td>";
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>