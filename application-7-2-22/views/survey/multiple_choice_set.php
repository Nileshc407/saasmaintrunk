<?php 
if($Multiple_choic_array) 
{
?>
	<label for="questionBalance"><span class="required_info">Apply Multiple Choice Question Set</span></label>
	<table class="table table-bordered table-hover">
	<thead>
		<tr>
		<th class="text-center">#</th>
		<th class="text-center">Options</th>							
		</tr>
	</thead>
	<tbody>			
	<?php 
	$i=1;
	foreach($Multiple_choic_array as $charray)
	{
	?>
		<tr>
			<td class="text-center"><?php echo $i; ?></td>
			<td class="text-center"><?php echo $charray['Option_values']; ?></td>
		</tr>
	<?php 
	$i++;
	}
	?>
	</tbody> 
	</table>
<?php 
} 
?>