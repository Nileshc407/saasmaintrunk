<?php if($Audit_Tracking != NULL) 
	{ 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Company Activity Log Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($From_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4> 
		<h4 style="text-align:center">
		<?php echo "Transaction From : "; 
		if($Transaction_from !== "") { echo $Transaction_from."," ; } else { echo "All ," ; }  echo " "."User Type : "; if($User_type == "") { echo "All User, " ; } if($User_type == 1) { echo "Customer, " ; } if($User_type == 2) { echo "Merchant, " ; } if($User_type == 3) { echo "Admin, " ; } if($User_type == 4) { echo "Partner admin, "; } if($User_type == 5) { echo "Merchandize Partner User, " ; } if($User_type == 6) { echo "Call Center User," ; } if($User_type == 7) { echo "Staff Users," ; } echo " Operation Mode : " ; if($Mode == "0") { echo "All" ; } if($Mode == 1) { echo "Insert"; }  if($Mode == 2) { echo "Update"; } if($Mode == 3) { echo "Delete"; } ?>  </h4>
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>	
					<tr>
						<th>Transction Date</th>
						<th>Who did</th>
						<th>User Type</th>
						<th>What was Done</th>
						<th>Menu Option</th>
						<th>To Whom</th>
						<th>Type of Operation</th> 
						<th>Operation Value</th>
					</tr>		
			</thead>
						<tbody>
						<?php
						
						if($Audit_Tracking != NULL)
						{	
							foreach($Audit_Tracking as $row)
							{
								/*if($row->Operation_type == 1)
								{
								  $Operation_type = 'Insert';
								}
								if($row->Operation_type == 2)
								{
								  $Operation_type = 'Update';
								}
								if($row->Operation_type == 3)
								{
								  $Operation_type = 'Delete';
								}
								if($row->From_userid == 1)
								{
								  $Ofrom_userId = 'Customer';
								}
								if($row->From_userid == 2)
								{
								  $Ofrom_userId = 'Merchant';
								}
								if($row->From_userid == 3)
								{
								  $Ofrom_userId = 'Admin';
								}
								if($row->From_userid == 4)
								{
								  $Ofrom_userId = 'Partner admin';
								}
								if($row->From_userid == 5)
								{
								  $Ofrom_userId = 'Merchandize Partner User';
								}*/						
								?>
									<tr>
										<td><?php echo $row->Date;?></td>
										<td><?php echo $row->Transaction_by;?></td>
										<td><?php echo $row->From_userid;?></td>
										<td><?php echo $row->Transaction_type;?></td>
										<td><?php echo $row->Transaction_from;?></td>
										<td><?php echo $row->Transaction_to;?></td>
										<td><?php echo $row->Operation_type;?></td>
										<td><?php echo $row->Operation_value;?></td>
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