
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_details->Company_name; ?></h1>
		<h2 style="text-align:center"><?php echo $Publisher_name; ?></h2>
		<h2 style="text-align:center"><?php echo $Export_file_name; ?></h2>
		<h4 style="text-align:center">File Name: <?php echo $File_name; ?></h4>
	</div>
	<div>
		<h5 style="text-align:right">Processed Date : <?php echo date("Y-m-d"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
			
					<tr style="background-color: #D9EDF7;">
						<th>Sr. No.</th>
						<th>Error Row No.</th>
						<th>Error Details</th>
						<th>Trans Date</th>
						<th>Bill No.</th>						
						<th>Identifier</th>
						<th>Purchased Miles</th>
						<th>Status</th>
                                                
						
					</tr>
			</thead>
			
			<tbody>
			<?php 
						$todays = date("Y-m-d");
						if($file_error_details != NULL)
						{			
							
							$i=1;					
							foreach($file_error_details as $row)
							{
								

								if($row->Status==44){
									$Status='Pending';
								} else if($row->Status==45){
									$Status='Approved';
								} else if($row->Status==46){
									$Status='Cancelled';
								} else {
									$Status='-';
								}

								
									echo "<tr>";
									echo "<td>".$i."</td>";	
									echo "<td>".$row->Error_row_no."</td>";	
									echo "<td>".$row->Error_in."</td>";								
									echo "<td>".$row->Error_transaction_date."</td>";
									echo "<td>".$row->Bill_no."</td>";									
									echo "<td>".$row->Card_id."</td>";
									echo "<td>".round($row->Transaction_amount)."</td>";
									echo "<td>".$Status."</td>";
                                    echo "</tr>";
							
								$i++;
								
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
