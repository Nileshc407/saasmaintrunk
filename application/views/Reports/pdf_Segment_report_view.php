<?php if(count($MembershipID) != 0) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Segment Report</h2>
		
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>MembershipID</th>
							<th>Member Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Total Spend  <?php echo '('.$Symbol_of_currency.')';?></th>
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if(count($MembershipID) > 0)
						{
							 
							for($i=0;$i<count($MembershipID);$i++)
							{
								
								echo "<tr>";
								echo "<td>".$MembershipID[$i]."</td>";
								echo "<td>".$Member_name[$i]."</td>";
								echo "<td>".$Phone_no[$i]."</td>";
								echo "<td>".$User_email_id[$i]."</td>";
								echo "<td>".$total_purchase[$i]."</td>";
								
								
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