			<?php	
				if(count($Get_linked_segment_items)>10)
				{
					$style="style='height: 500px;overflow: auto;'";
				}
				else
				{
					$style="style='overflow: auto;'";
				}
				?>			
		<div class="table-responsive"   <?php echo $style;?>>
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center"><b>Item Code</b></th>
					<th class="text-center"><b>Item Name</b></th>
					<th class="text-center"><b>Quantity</b></th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
				if($Get_linked_segment_items!=NULL){
					foreach($Get_linked_segment_items as $row)
					{
					?>
						<tr>
							
							<td class="text-center"><?php echo $row->Company_merchandize_item_code; ?></td>
							<td class="text-center"><?php echo $row->Merchandize_item_name; ?></td>
							<td class="text-center"><?php echo $row->Quantity; ?></td>
						</tr>
					<?php
					}
					}
				?>	
				</tbody> 
			</table>
			
		</div>
						
<script>
	$( "#close_modal3" ).click(function(e)
	{
		
		$('#Item_modal').hide();
		$("#Item_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
</script>	
					
