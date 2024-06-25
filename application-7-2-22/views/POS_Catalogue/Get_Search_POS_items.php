<?php
				if($POS_Items_Records != NULL)
				{?>	
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center">Action</th>
					<th class="text-center">Item Code</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">POS Item Name</th>
					<th class="text-center">Menu Category</th>
					<th class="text-center">Validity</th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
						
						$ci_object = &get_instance();
						$ci_object->load->model('POS_catlogueM/POS_catalogue_model');
						
					foreach($POS_Items_Records as $row)
					{
						
						
						$Todays_date=date("Y-m-d");
						$Color="";
						$Status="<font color='red'>Disable</font>";
						if($Todays_date>=$row->Valid_from && $Todays_date<=$row->Valid_till)
						{
							$Color="green";
						}
						
						$Item_type_details = $ci_object->POS_catalogue_model->Get_Specific_Code_decode_master($row->Merchandize_item_type);
						
						$POS_item_type= $Item_type_details->Code_decode;
						
					?>
							<tr>
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/POS_CatalogueC/Edit_POS_Items/?Company_merchandise_item_id=<?php echo $row->Company_merchandise_item_id;?>" title="Edit">
									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
								<a href="javascript:void(0);" onclick="Merchandize_Item_inactive('<?php echo $row->Company_merchandise_item_id;?>','<?php echo $row->Merchandize_item_name; ?>');" title="Delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>
							</td>
							<td class="text-center"><?php echo $row->Company_merchandize_item_code; ?></td>
							<td class="text-center"><?php echo $POS_item_type; ?></td>
							<td><?php echo $row->Merchandize_item_name; ?></td>
							<td><?php echo $row->Merchandize_category_name; ?></td>
							
							<td><?php echo "<font color=".$Color.">".$row->Valid_from.' To '.$row->Valid_till."</font>"; ?></td>
							
							
						</tr>
					<?php
					}
				} else
	{
	?>
	
	<div class="panel panel-info">
		<div class="panel-heading text-center"><h4>No Records Found</h4></div>
	</div>
	
	<?php } ?>				
				</tbody> 
			</table>
		</div>