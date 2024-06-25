<?php if($Failed_login != NULL) 
	{ 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Failed Login Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($From_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4> 
		<h4 style="text-align:center">
		<?php 
		
			 // echo "---Company_id---".$Company_id."<br>";
		// echo "---start_date---".$start_date."<br>";
		// echo "---end_date---".$end_date."<br>";
		// echo "---enter_user---".$enter_user."<br>";
		// echo "---User_type---".$User_type."<br>";
		// echo "---Report_type---".$Report_type."<br>";
		// echo "---Source---".$Source."<br>"; 
		//echo "Transaction From : "; 
		/* if($Transaction_from !== "") { echo $Transaction_from."," ; } else { echo "All ," ; } */  echo " "."User Type : "; if($User_type == "0") { echo "All User, " ; } if($User_type == 1) { echo "Customer, " ; } if($User_type == 2) { echo "Merchant, " ; } if($User_type == 3) { echo "Admin, " ; } if($User_type == 4) { echo "Partner admin, "; } if($User_type == 5) { echo "Merchandize Partner User, " ; } if($User_type == 6) { echo "Call Center User," ; } if($User_type == 7) { echo "Staff Users," ; }
		
		echo " Source : "; if($Source == 0) { echo "All Source,"; } 
		
		if($Source == 1) { echo "Android APP"; } 
		if($Source == 2) { echo "iOS APP"; } 
		if($Source == 3) { echo "Member Website"; } 
		if($Source == 4) { echo "Backend Application"; } 
		echo " Report Type : ";if($Report_type == 0) { echo "Summary" ; } 
		if($Report_type == 1) { echo "Details"; }
		?>  </h4>
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>	
					<tr>
			<?php if($Report_type == 1) { ?> <th>Date</th> <?php } ?> 
						<th>Name</th>
						<th>Email Address</th>
						<?php if($Report_type == 1) { ?><th>Attempted Password</th><?php } ?> 
						<th>User Type</th>
						<th>Total Attempts</th>
						<?php if($Report_type == 1) { ?><th>Source</th><?php } ?> 
					</tr>		
			</thead>
						<tbody>
						<?php
						
						if($Failed_login != NULL)
						{	
							foreach($Failed_login as $row)
							{
								
								if($row->Location == ""){
									$Location='';
								} else {
									$Location= " ( ".$row->Location." )";
								}
								
								?>
									<tr>
										<?php if($Report_type == 1) { ?>  <td><?php echo $row->Date;?></td> <?php } ?> 
										<td><?php echo $row->FirstName.' '.$row->LastName;?></td>
										<td><?php echo $row->EmailAddress;?></td>
										<?php if($Report_type == 1) { ?>  <td><?php echo $row->AttemptedPassword;?></td><?php } ?> 
										<td><?php echo $row->UserType;?></td>
										<td><?php echo $row->FailedAttempts;?></td>
										<?php if($Report_type == 1) { ?>  <td><?php echo $row->Source;?><br><div style='width:200px;word-break:break-word;'> <?php echo $Location;?> </div> </td><?php } ?> 
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