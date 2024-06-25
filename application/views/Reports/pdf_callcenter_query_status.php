<?php 
if($Query_status != NULL) 
	{ 
?> 
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Query Status Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($From_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4> 
	
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">	
			<thead>	
					<tr style="background-color: #D9EDF7;">
						<th>Query Log Ticket</th>
						<th>Membership Id</th>
						<th>Customer Name</th>
						<th>Assign / Forwarded</th>
						<th>Query Type </th>
						<th>Sub Query</th>
						<th>Query Details</th> 
						<th>Query Interaction</th>
						<th>Call Type</th>
						<th>Communication</th>
						<th>Status</th>
						<th>Registered Date</th>
						<th>Close Date</th>
					</tr>		
			</thead>
			<tbody>
						<?php
						
						if($Query_status != NULL)
						{	
							foreach($Query_status as $row)
							{				
								?>
									<tr>
										<td><?php echo $row->Querylog_ticket;?></td>
										<td><?php echo $row->Membership_id;?></td>
										<td><?php echo $row->Full_name; ?>	</td>
										<td><?php echo $row->Full_name1; ?>	</td>
										<td><?php echo $row->Query_type_name;?></td>
										<td><?php echo $row->Sub_query;?></td>
										<td><?php echo $row->Query_details;?></td>
										<td><?php echo $row->Query_interaction;?></td>
										<td><?php echo $row->Call_type;?></td>
										<td><?php echo $row->Communication_type;?></td>
										<td><?php echo $row->Query_status;?></td>
										<td><?php echo $row->Creation_date;?></td>
										<td><?php echo $row->Closure_date;?></td>
									</tr>
							<?php		
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>