						
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center">Item Code</th>
					<th class="text-center">Item Name</th>
					<th class="text-center">Menu Group</th>
					<th class="text-center">Discount_percentage_or_value</th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
				// foreach($Item_code3 as $Item_code)
				for($i=0;$i<count($Item_code3);$i++)
				{ ?>
					<tr>
							
							<td class="text-center"><?php echo $Item_code3[$i]; ?></td>
							<td class="text-center"><?php echo $Merchandize_item_name3[$i]; ?></td>
							<td class="text-center"><?php echo $Merchandize_category_name3[$i]; ?></td>
							<td class="text-center"><?php echo $Discount_percentage_or_value3[$i]; ?></td>
							
						</tr>
				<?php }
				
				/*
					foreach($Get_linked_discount__items as $row)
					{
					?>
						<tr>
							
							<td class="text-center"><?php echo $row->Company_merchandize_item_code; ?></td>
							<td class="text-center"><?php echo $row->Merchandize_item_name; ?></td>
							<td class="text-center"><?php echo $row->Discount_percentage_or_value; ?></td>
						</tr>
					<?php
					}*/
				?>	
				</tbody> 
			</table>
			
		</div>
						
						
					
