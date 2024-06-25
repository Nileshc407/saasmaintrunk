
<?php if($MerchantCommunication != NULL)
	{	
	?>
<table  class="table table-bordered table-hover" id="detail_myModal1">
	<thead>
		 	<h4 class="modal-title" style="background-color:#31859C;color:#fff;text-align:center">Communication Offer</h4>
	</thead>
	<tbody>
	<?php	
		foreach($MerchantCommunication as $comm_details)
		{
			echo "<tr><td><b>".$comm_details['communication_plan']."</b> - ".$comm_details['description']."</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		}	
	?>	
	</tbody>
</table>
<?php
	}
	else
	{
	?>
	<div class="progress">						
		<div class="progress-bar" style="width: 100%"><span class="info-box-number" >Sorry! no communication offers</span></div>
	</div>
	
	<?php
	}
?>
<script>
	
	// onclick="closePopUp('dialog2');"
/* document.getElementById('detail_myModal1').onclick = function()
{
    document.getElementById('modal-dialog').style.display = 'none'; 
	// $( "#modal-dialog" ).dialog("destroy");
} */
</script>




