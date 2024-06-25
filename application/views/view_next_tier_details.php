<div class="element-wrapper">                
	<div class="element-box">
	  <h5 class="form-header">
	  Upgrade Tier
	  </h5>       
		<?php
		$todays = date("Y-m-d");
		
			if($tier_array != NULL)
			{
		?>	  
	  <div class="table-responsive">
		<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
			<thead>
				<tr>
				<th class="text-center">Tier Name</th>
				<th class="text-center">Level</th>
				<th class="text-center">Tier Criteria</th>
				<th class="text-center">Value</th>
				<th class="text-center">Criteria Period </th>
				</tr>
			</thead>	
				

			<tbody>
					<?php
							foreach($tier_array as $row)
							{
								
								
								if($row->Tier_criteria == 1 )
								{
									$Tier_criteria = "Cumulative Spend";
								}
								
								if($row->Tier_criteria == 2 )
								{
									$Tier_criteria = "Cumulative Number of Transactions";
								}
								
								if($row->Tier_criteria == 3 )
								{
									$Tier_criteria = "Cumulative Points Accumlated";
								}
								
								if($row->Tier_criteria == 4 )
								{
									$Tier_criteria = "Tenor - No. of Days";
								}
	

							?>
						<tr >

									<td class="text-center"><?php echo $row->Tier_name; ?></td>
									<td><?php echo $row->Tier_level_id;?></td>
									<td><?php echo  $Tier_criteria; ?> </td>	
									<td><?php echo $row->Criteria_value;?></td>
									<td><?php echo $row->Excecution_time;?></td>
					
								</tr>
							<?php
							}
						
						
						?>					
			</tbody> 
			</table>
		  </div>
	  <?php
		}
		else
			{
				echo "<b>This is a Highest Tier.</b>";
			}
	?>
		</div>
	  </div>