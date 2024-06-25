						<?php 	
						if($Get_pos_side_groups_items !=NULL)
						{
							$height = '';
							if(count($Get_pos_side_groups_items) >= 10)
							{
								$height = 'style="overflow-y: scroll;height:300px;"';
							}
						?>
						<div class="col-md-12"  id="Side_group_item_block"   <?php echo $height; ?>>
						<div class="table-responsive" id="show_records">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center">Side Option</th>
					<th class="text-center">Side Item Name</th>
					<th class="text-center">Side Group Item Code</th>
					<th class="text-center">Side Group Item Name</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Price</th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
				
					foreach($Get_pos_side_groups_items as $row)
					{
						
						
						
						
					?>
						<tr>
							
							<td class="text-center"><?php echo $row->Side_option; ?></td>
							<td class="text-center"><?php echo $row->Merchandize_category_name; ?></td>
							<td class="text-center"><?php echo $row->Side_group_item_code; ?></td>
							<td class="text-center"><?php echo $row->Merchandize_item_name; ?></td>
							<td class="text-center"><?php echo $row->Quanity; ?></td>
							<td class="text-center"><?php echo $row->Price; ?></td>
							
							
							
						</tr>
					<?php
					}
				?>	
				</tbody> 
			</table>
			
		</div>
		</div>
						<?php
					}
				?>	
						
					
