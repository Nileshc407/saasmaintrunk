<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Category Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($start_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4>
		
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
							<th>Menu Group</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if($Trans_Records != NULL)
						{
							
							$ci_object = &get_instance(); 

							foreach($Trans_Records as $row)
							{
								
									echo "<tr>";
									echo "<td>".$row->MembershipID."</td>";
									echo "<td>".$row->Member_name."</td>";
									echo "<td>".$row->Phone_no."</td>";
									echo "<td>".$row->Menu_group."</td>";
									echo "<td>".$row->Times_purchased."</td>";
									// echo "<td>".number_format(round($row->Value),2)."</td>";
									echo "<td>".$row->Value."</td>";
									
									
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