<table   width="100%" class="table table-striped table-lightfont">
	<thead>
	<tr >
		<th class="text-center">Select</th>
		<th class="text-center">Merchant Name</th>
		<th class="text-center">Communication Offer</th>
		<th class="text-center">Description</th>
	</tr>
	</thead>

	<tbody>
	<?php	
	if($communication_offers != NULL)
	{
		foreach($communication_offers as $commu_offers)
		{
		?>
			<tr>
				<td class="text-center">
					<div class="checkbox">
						<label>
							<input type="checkbox" value="<?php echo $commu_offers['id']; ?>" name="offer_list[]" class="checkbox1">
						</label>
					</div>
				</td>
				<td width="10%"><?php echo $commu_offers['First_name']." ".$commu_offers['Last_name']; ?></td>
				<td width="10%"><?php echo $commu_offers['communication_plan']; ?></td>
				<td><?php echo $commu_offers['description']; ?></td>
			</tr>
		<?php
		}
	}
	else
	{
	?>
		<tr>
			<td colspan="4" class="text-center"><div class="help-block form-text with-errors form-control-feedback" >No Communication Offers are Present. Please Create new Offers.</div></td>
		</tr>
	<?php
	}
	?>
	
		<tr>
			<td  colspan="4" class="text-center"><div class="help-block form-text with-errors form-control-feedback" id="alert_msg"></div></td>
		</tr>
	<tr>
		<?php	
		if($communication_offers != NULL)
		{
		?>
			<td>			
				<button type="button" id="checkAll" class="btn btn-primary">Select All</button>
			</td>
		<?php
		}
		?>
		<td><button type="button" id="close_modal" class="btn btn-primary">Save Applied Communication(s)</button></td>
		<td colspan="2" ><button type="button" id="close_modal12" class="btn btn-primary">Close</button></td>
	</tr>
	</tbody>
</table>

<script>
$(document).ready(function() 
{	
	$("#checkAll").attr("data-type", "check");
	$("#checkAll").click(function() 
	{
		if ($("#checkAll").attr("data-type") === "check") 
		{
			$(".checkbox1").prop("checked", true);
			$("#checkAll").attr("data-type", "uncheck");
		} 
		else 
		{
			$(".checkbox1").prop("checked", false);
			$("#checkAll").attr("data-type", "check");
		}
	});
});

$( "#close_modal12" ).click(function(e)
	{
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal" ).click(function(e)
	{
		 var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
		//alert(val)
		if(val == "")
		{
			$("#alert_msg").html("Please Select at least one Communication Offer");
			return false;
		}
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});	
</script>