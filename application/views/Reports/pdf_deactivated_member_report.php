<?php if($Users_Records != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h2 style="text-align:center">Deactivated Members From System</h2>
		<h4 style="text-align:center">Report Date : <?php echo $Report_date; ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<tr style="background-color: #D9EDF7;">
				
				<th class="text-center">User Name</th>
				<th class="text-center">User Type</th>
				<th class="text-center">Membership ID</th>
				<th class="text-center">Membership Date</th>
				<th class="text-center">Phone No.</th>
				<th class="text-center">Total <?php echo $Company_details->Currency_name; ?> </th>
				<th class="text-center">Total Redeem <?php echo $Company_details->Currency_name; ?> </th>
				<th class="text-center">Total Bonus <?php echo $Company_details->Currency_name; ?> </th>
			</tr>
			</thead>
			
			<tbody>
			<?php
			if($Users_Records != NULL)
				{
					foreach($Users_Records as $row)
					{	
						//$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name; ?>
					<tr>
						
						<td><?php echo $row->Name; ?></td>
						<td><?php echo $row->User_type;?></td>
						<td><?php echo $row->Membership_id;?></td>
						<td><?php echo date("Y-m-d", strtotime($row->Membership_date));?></td>
						<td><?php echo $row->Phone_no;?></td>
						<td><?php echo $row->Current_balance;?></td>
						<td><?php echo $row->Total_reddems;?></td>
						<td><?php echo $row->Total_topup_amt;?></td>
					</tr>
		<?php 		}
				}
			?>			
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>
