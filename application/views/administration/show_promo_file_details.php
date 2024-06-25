 

<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
	<thead>
	<tr>
		
	
		
		<th>Promo Code</th>
		<th>Points</th>
		<th>Status</th>

	</tr>
	</thead>

	<tbody>
	<?php	
	if($PromoDetails != NULL)
	{
		foreach($PromoDetails as $promo_details)
		{
	?>
			<tr>
				
				
				<td><?php echo $promo_details->Promo_code; ?></td>
				<td><?php echo $promo_details->Points; ?></td>
				<td><?php if($promo_details->Promo_code_status == 1)
							{echo "<b>Utilize</b>";} else {echo "Unutilize";}?></td>

				
			</tr>
	<?php
		}
	}
	?>
	
	</tbody>
</table>


