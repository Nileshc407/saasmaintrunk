				<?php
				
					//foreach($Get_linked_segment_items as $row)
					if(count($Item_code3)> 10)
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
				
					//foreach($Get_linked_segment_items as $row)
					for($i=0;$i<count($Item_code3);$i++)
					{
					?>
						<tr>
							<td class="text-center"><?php echo $Item_code3[$i]; ?></td>
							<td class="text-center"><?php echo $Merchandize_item_name3[$i]; ?></td>
							<td class="text-center"><?php echo $Seg_Quantity3[$i]; ?></td>
							
						</tr>
					<?php
					}
				?>	
				</tbody> 
			</table>
			
		</div>
						
						
					
