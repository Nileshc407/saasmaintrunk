<?php if($Seller_report_details != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h2 style="text-align:center">Inactive Users Report</h2>
		<h4 style="text-align:center">Report Date : <?php echo $Report_date; ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
			<tr style="background-color: #D9EDF7;">
				
				<th class="text-center">User Name</th>
				<th class="text-center">User Type</th>
				<th class="text-center">Membership ID</th>
				<th class="text-center">City</th>
				<th class="text-center">Phone No.</th>
				<th class="text-center">Total <?php echo $Company_details->Currency_name; ?> </th>
				<th class="text-center">Total Redeem <?php echo $Company_details->Currency_name; ?> </th>
				<th class="text-center">Total Bonus <?php echo $Company_details->Currency_name; ?> </th>
			</tr>
			</thead>
			
			<tbody>
			<?php
			foreach($Seller_report_details as $row)
			{
			?>					
				<tr>
					<td class="text-center"><?php echo $row['UserName'];?></td>
					<td><?php echo $row['UserType'];?></td>
					<td><?php echo $row['MembershipId'];?></td>
					<td><?php echo $row['City']; ?> </td>
					<td><?php echo App_string_decrypt($row['PhoneNo']);?></td>
					<td><?php echo $row['TotalLoyaltyPoints'];?></td>
					<td><?php echo $row['TotalReddemPoints'];?></td>
					<td><?php echo $row['TotalBonusPoints'];?></td>			
				</tr>
			<?php
			}
			?>			
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>
