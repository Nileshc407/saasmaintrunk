				<?php 	
						if($Get_pos_main_items !=NULL)
						{
							$height = '';
							if(count($Get_pos_main_items) >= 10)
							{
								$height = 'style="overflow-y: scroll;height:300px;"';
							}
						?>		
						<div class="table-responsive"  <?php echo $height; ?>>
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center">Main Item Name</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Price</th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
				
					foreach($Get_pos_main_items as $row)
					{
						
						
						
						
					?>
						<tr>
							
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
						
							<?php
					}
				?>	
					
