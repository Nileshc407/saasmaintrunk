<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">
			<?php  echo 'Yearly Loyalty Report'; 	?>
		</h2>
	
	</div>                 
  <div class="table-responsive">
	<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		<thead>

			<tr>
					<th>Year</th>
					<th>Month</th>
					<th>Business/Merchant</th>
					<th>Outlet</th>
					<th>Tier</th>
					<th>Earned <?php echo $Company_details->Currency_name; ?></th>
							<th>Earned <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
							<th>Redeemed <?php echo '('.$Symbol_of_currency.')';?></th>
			</tr>
			

		</thead>
		<tbody>
	<?php
						$todays = date("Y-m-d");
						 $Outlet_id = $_REQUEST["Outlet_id"];
						$seller_id = $_REQUEST["seller_id"];
						$Year = $_REQUEST["Year"];
						$Tier = $_REQUEST["member_tier_id"];
						$Brand_name = $_REQUEST["Brand_name"];
						  
						if(count($Trans_Records) > 0)
						{
							if($Brand_name=='0'){$Brand_name='All';}
							foreach($Trans_Records as $row)
							{
									echo "<tr>";
									echo "<td>".$row->TransYear."</td>";
									echo "<td>".$row->TransMONTH."</td>";
									echo "<td>".$row->Business/Merchant."</td>";
									echo "<td>".$row->Outlet."</td>";
									echo "<td>".$row->Tier_name."</td>";
									echo "<td>".round($row->Earned_pts)."</td>";
									echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
									echo "<td>".round($row->Redeemed_pts)."</td>";
									echo "<td>".number_format(round($row->Redeem_amount),2)."</td>";
							}
						}
						?>
		</tbody>
	</table>
	
  </div>
</div>
