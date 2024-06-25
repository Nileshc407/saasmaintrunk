 <?php $this->load->view('header/header');?>

	<div class="row">
		<div class="col-md-12">
			<h1 class="page-head-line">Required/Optional Condiments Group</h1>
		</div>
	</div>
	
	<div class="row">
	
	
		<?php echo form_open('POS_CatalogueC/Create_Required_Optional_Condiments'); ?>
		<div class="col-md-6 col-md-offset-3">
		
		<?php
			
		

		if($Condiment_groupId > 0)
		{
				// edit form
		?>
			<div class="panel panel-default">                        
				
				<div class="panel-body">			
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">* </span>Company Name</label>
						<select class="form-control" name="Company_id" id="CompanyId" required>
							<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>							
					</div>
					
					<div class="form-group">
						<label for=""><span class="required_info">* </span>Condiment Type</label>
						<select class="form-control" name="Condiment_type" required>
						<?php
							foreach($code_decode_types as $d){
								if(in_array($d->Code_decode_type_id,[14,15])){
									if($d->Code_decode_type_id == $Condiment_type){
										echo "<option selected value='$d->Code_decode_type_id'>".$d->Code_decode_type."</option>";
									}
									else{
									echo "<option value='$d->Code_decode_type_id'>".$d->Code_decode_type."</option>";
									}
								}
							}
						?>
						</select>							
					</div>
					
					<div class="form-group  has-feedback-glyphicon2" >
						<label for=""><span class="required_info">* </span>Group Code</label>
						<input type="text" class="form-control"  placeholder="Enter Group Code" name="Group_code"  id="Group_code" readonly value="<?php echo $Group_code; ?>"/>
						<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
						<div class="help-block help-block-glyphicon2"></div>
					</div>
					
					<div class="form-group  has-feedback-glyphicon3" >
						<label for=""><span class="required_info">* </span>Group Name</label>
						<input type="text" class="form-control"  placeholder="Enter Group Name" name="Group_name"  id="Group_name" required pattern=".{1,}" value="<?php echo $Group_name; ?>" />
						<span class="glyphicon" id="glyphicon3" aria-hidden="true"></span>
						<div class="help-block help-block-glyphicon3"></div>
					</div>
					
					<div class="form-group">
						<label for=""><span class="required_info">* </span>Label</label>
						<input type="text" class="form-control" placeholder="Enter label for group" name="Label" id="Label" required value="<?php echo $Label; ?>" />
					
					</div>
					
					<div class="form-group">
						<label for=""><span class="required_info">* </span>Menu Group</label>
						<select class="form-control" name="Menu_group_id" id="Menu_group" required>
						<?php
							foreach($Merchandize_Category_list as $d1){
								if($d1->Merchandize_category_id == $Menu_group_id){
									echo "<option selected value='$d1->Merchandize_category_id'>".$d1->Merchandize_category_name."</option>";
								}
								else{
								echo "<option value='$d1->Merchandize_category_id'>".$d1->Merchandize_category_name."</option>";
								}
							}
						?>
						</select>							
					</div>
					
					<div class="form-group" id="Item_codes">
						<label for=""><span class="required_info">* </span>Items Linked With Group</label>
						<select class="form-control" name="Condiment_item_code[]" required  multiple>
							<?php
								foreach($Category_items_list as $e)
								{
									if(in_array($e->Company_merchandize_item_code,$linked_items_list)){
										echo "<option selected value='$e->Company_merchandize_item_code'>".$e->Merchandize_item_name."</option>";
									}
									else{
										echo "<option value='$e->Company_merchandize_item_code'>".$e->Merchandize_item_name."</option>";
									}
								}
							?>
						</select>							
					</div>
					
					<input type="hidden" name="operationFlag" value="2">
					<button type="submit" id="Register" class="btn btn-primary">Update</button>
					
				</div>						
			</div>
		<?php
			
		}
		else
		{
		?>
		
			<div class="panel panel-default">                        
				
				<div class="panel-body">			
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">* </span>Company Name</label>
						<select class="form-control" name="Company_id" id="CompanyId" required>
							<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>							
					</div>
					
					<div class="form-group">
						<label for=""><span class="required_info">* </span>Condiment Type</label>
						<select class="form-control" name="Condiment_type" required>
						<option value="">Select condiment type</option>
						<?php
							foreach($code_decode_types as $d){
								if(in_array($d->Code_decode_type_id,[14,15])){
								echo "<option value='$d->Code_decode_type_id'>".$d->Code_decode_type."</option>";
								}
							}
						?>
						</select>							
					</div>
					
					<div class="form-group  has-feedback" >
						<label for=""><span class="required_info">* </span>Group Code</label>
						<input type="text" class="form-control"  placeholder="Enter Group Code" name="Group_code"  id="Group_code" required onkeyup="this.value=this.value.replace(/\s/g,'')" />
						<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>
						<div class="help-block" id="help-block2"></div>
					</div>
					
					<div class="form-group  has-feedback-glyphicon3" >
						<label for=""><span class="required_info">* </span>Group Name<span class="required_info"> (Name must contain 3 or more characters)</span> </label>
						<input type="text" class="form-control"  placeholder="Enter Group Name" name="Group_name"  id="Group_name" required pattern=".{3,}" />
						<span class="glyphicon" id="glyphicon3" aria-hidden="true"></span>
						<div class="help-block help-block-glyphicon3"></div>
					</div>
					
					<div class="form-group">
						<label for=""><span class="required_info">* </span>Label</label>
						<input type="text" class="form-control" placeholder="Enter label for group" name="Label" id="Label" required />
					
					</div>
					
					<div class="form-group">
						<label for=""><span class="required_info">* </span>Menu Group</label>
						<select class="form-control" name="Menu_group_id" id="Menu_group" required>
						<option value="">Select Menu Group</option>
						<?php
							foreach($Merchandize_Category_list as $d1){
			
								echo "<option value='$d1->Merchandize_category_id'>".$d1->Merchandize_category_name."</option>";
							}
						?>
						</select>							
					</div>
					
					<div class="form-group" id="Item_codes">
						<label for=""><span class="required_info">* </span>Items Linked With Group</label>
						<select class="form-control" name="Condiment_item_code[]" required  multiple>
							<option value="">Select Items</option>
						</select>							
					</div>
					
					<input type="hidden" name="operationFlag" value="1">
					<button type="submit" id="Register" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-primary">Reset</button>
					
				</div>						
			</div>
		<?php 
			}
		?>
		</div>
		<?php echo form_close(); 
		?>
	</div>
	
	<div class="panel panel-info">
		<div class="panel-heading"><h4>Required/Optional Condiments Groups</h4></div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center">Action</th>
					<th class="text-center">Group Code</th>
					<th class="text-center">Group Name</th>
					<th class="text-center">Condiment Type</th>
					<th class="text-center">Label</th>
					<th class="text-center">Condiment Item</th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
				// var_dump($result_data);
				if($result_data != NULL)
				{
					foreach($result_data as $row)
					{
					?>
						<tr>
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/POS_CatalogueC/Create_Required_Optional_Condiments/?GroupCode=<?php echo $row->Group_code;?>" title="Edit">
									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
								|
								<a href="javascript:void(0);" onclick="delete_group('<?php echo $row->Group_code;?>','<?php echo $row->Group_name; ?>');" title="Delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>
							</td>
							
							<td><?php echo $row->Group_code; ?></td>
							<td><?php echo $row->Group_name; ?></td>
							<td><?php if ($row->Condiment_type == 14){ echo "Required"; } else{ echo "Optional"; } ?></td>
							<td><?php echo $row->Label; ?></td>
							<td><?php echo $row->Merchandize_item_name; ?></td>
						</tr>
					<?php
					}
				}
				?>			
				</tbody> 
			</table>
		</div>
		<div class="panel-footer"><?php echo $pagination; ?></div>
	</div>
	
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
<script>

$('#Group_code').blur(function()
	{
		var Group_codeVal = $("#Group_code").val();
		var Group_CompanyId = $("#CompanyId").val();
		
		if(Group_codeVal != "" || Group_codeVal != NULL)
		{
			//alert(Branch_code);
			$.ajax({
				  type: "POST",
				  data: {Group_code: Group_codeVal,Group_CompanyId:Group_CompanyId},
				  url: "<?php echo base_url()?>index.php/POS_CatalogueC/check_required_optional_group",
				  success: function(data)
				  {
					if(data == 1)
					{
						$('#Group_code').val('');
						
						has_error(".has-feedback","#glyphicon","#help-block2","Condiments Group Code Is Already Exist.!!");
					}
					else
					{
						has_success(".has-feedback","#glyphicon","#help-block2","");
					}
					
				  }
			});
		}
	});

$('#Menu_group').change(function()
	{
		var Menu_groupVal = $("#Menu_group").val();
		
		if(Menu_groupVal != "" || Menu_groupVal != NULL)
		{
			//alert(Branch_code);
			$.ajax({
				  type: "POST",
				  data: {Merchandize_category_id: Menu_groupVal},
				  url: "<?php echo base_url()?>index.php/POS_CatalogueC/Get_Category_Merchandize_Items",
				  success: function(data)
				  {
					$("#Item_codes").html(data.ItemsListHtml);
				  }
			});
		}
	});
	
	function delete_group(code,gpname)
	{	
		var compId = document.querySelector("#CompanyId").value;
		
			var url = '<?php echo base_url()?>index.php/POS_CatalogueC/delete_required_optional_condiments?GroupCode='+code+'&Company_id='+compId;
			BootstrapDialog.confirm("Are you sure to delete '"+gpname+"' ?", function(result) 
			{
				if (result == true)
				{
					show_loader();
					window.location = url;
					return true;
				}
				else
				{
					return false;
				}
			});
		
		
		
	}
</script>