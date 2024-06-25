<?php $this->load->view('header/header');?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				 echo form_open_multipart('POS_CatalogueC/Create_Required_Optional_Condiments'); ?>

				<input type="hidden" name="Create_user_id" value="<?php echo $enroll;?>">
				<input type="hidden" name="Create_date" value="<?php echo date("Y-m-d H:i:s");?>">
				<div class="element-wrapper">
					<h6 class="element-header">Required/Optional Condiments Group</h6>
					<div class="element-box">
					<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_box" style="display:none;"></div>
				<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code'); ?>
							</div>
				<?php 	} 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
				<?php 	} 
			if($Condiment_groupId > 0)
			{
				?>
				
				<div class="row">
				<div class="col-sm-6">										
					<div class="form-group has-feedback"  id="has-feedback1">
					<label for=""><span class="required_info">*</span>  Company Name </label>
					<select class="form-control" name="Company_id" id="CompanyId" required >
							<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
					</select>						
					<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
					<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					</div>
					
					<div class="form-group has-feedback"  id="has-feedback1">
					<label for=""><span class="required_info">*</span>  Condiment Type </label>
					<select class="form-control" name="Condiment_type" id="Condiment_type" required >
							<option value="">Select condiment type</option>
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
					<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
					<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					</div>
					
					<div class="form-group has-feedback"  id="has-feedback1">
						<label for=""><span class="required_info">*</span> Group Code </label>
						<input type="text" name="Group_code" id="Group_code" class="form-control" placeholder="Enter Group Code " value="<?php echo $Group_code; ?>" required onkeyup="this.value=this.value.replace(/\s/g,'')" />						
						<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
					</div>
					
	
				<div class="form-group has-feedback">
					<label for=""><span class="required_info">*</span> Group Name <span class="required_info"> (Name must contain 3 or more characters)</span></label>
					<input type="text" name="Group_name" id="Group_name" class="form-control" value="<?php echo $Group_name; ?>" placeholder="Enter Group Name" required />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
						<label for=""><span class="required_info">* </span>Label</label>
						<input type="text" class="form-control" placeholder="Enter label for group" name="Label" id="Label" required value="<?php echo $Label; ?>" />
					
					</div>
					
				<div class="form-group">
						<label for=""><span class="required_info">*</span> Main Group</label>
							<select class="form-control" name="Menu_group_id" id="Menu_group" required >
								<option value="">Select Main Group</option>
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
			<div class="row">
				<div class="col-sm-6">										
					<div class="form-group has-feedback"  id="has-feedback1">
					<label for=""><span class="required_info">*</span>  Company Name </label>
					<select class="form-control" name="Company_id" id="CompanyId" required >
							<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
					</select>						
					<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
					<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					</div>
					
					<div class="form-group has-feedback"  id="has-feedback1">
					<label for=""><span class="required_info">*</span>  Condiment Type </label>
					<select class="form-control" name="Condiment_type" id="Condiment_type" required >
							<option value="">Select condiment type</option>
						<?php
							foreach($code_decode_types as $d){
								if(in_array($d->Code_decode_type_id,[14,15])){
								echo "<option value='$d->Code_decode_type_id'>".$d->Code_decode_type."</option>";
								}
							}
						?>
					</select>						
					<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
					<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					</div>
					
					<div class="form-group has-feedback"  id="has-feedback1">
						<label for=""><span class="required_info">*</span> Group Code </label>
						<input type="text" name="Group_code" id="Group_code" class="form-control" placeholder="Enter Group Code " required onkeyup="this.value=this.value.replace(/\s/g,'')" />						
						<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
					</div>
					
	
				<div class="form-group has-feedback">
					<label for=""><span class="required_info">*</span> Group Name <span class="required_info"> (Name must contain 3 or more characters)</span></label>
					<input type="text" name="Group_name" id="Group_name" class="form-control" placeholder="Enter Group Name" required />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
						<label for=""><span class="required_info">* </span>Label</label>
						<input type="text" class="form-control" placeholder="Enter label for group" name="Label" id="Label" required />
					
					</div>
					
				<div class="form-group">
						<label for=""><span class="required_info">*</span> Main Group</label>
							<select class="form-control" name="Menu_group_id" id="Menu_group" required >
								<option value="">Select Main Group</option>
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
			</div>	
				
			</div>
			
			<div class="form-buttons-w" align="center">
				<button class="btn btn-primary" type="submit" id="Register">Submit</button>
				<button class="btn btn-primary" type="reset">Reset</button>
				
			  </div>
		<?php
		}
		?>

			  
		</div>
	</div>
	<?php echo form_close(); ?>	
				
				<!--------------Table------------->	
<?php
				if($result_data != NULL)
				{?>					
				<div class="element-wrapper">											
					<div class="element-box">
					  <h5 class="form-header">
					  Required/Optional Condiments Groups
					  </h5>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
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
							<tfoot>
								<tr>
									<th class="text-center">Action</th>
									<th class="text-center">Group Code</th>
									<th class="text-center">Group Name</th>
									<th class="text-center">Condiment Type</th>
									<th class="text-center">Label</th>
									<th class="text-center">Condiment Item</th>
									
								</tr>
							</tfoot>
							<tbody>
						<?php
				
					foreach($result_data as $row)
					{
					?>
						<tr>
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/POS_CatalogueC/Create_Required_Optional_Condiments/?GroupCode=<?php echo $row->Group_code;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								|
								<a href="javascript:void(0);" onclick="delete_me('<?php echo $row->Group_code;?>','<?php echo $row->Group_name; ?>','','POS_CatalogueC/delete_required_optional_condiments?Company_id=<?php echo $Company_id;?>&GroupCode');" data-target="#deleteModal" data-toggle="modal" title="Delete">
									<i class="os-icon os-icon-ui-15"></i>
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
				?>	
							
						</tbody>
						</table>
					  </div>
					</div>
				</div>
			<?php
				}
				else
				{
				?>
				
				<div class="panel panel-info">
					<div class="panel-heading text-center"><h4>No Records Found</h4></div>
				</div>
	
	<?php } ?>	
				<!--------------Table--------------->
			</div>
		</div>	
	</div>
</div>

		
<?php $this->load->view('header/footer'); ?>
		
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

<style>
.thumbnail {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
}
.thumbnail>img 
{
    margin-right: auto;
    margin-left: auto;
}
.img-responsive, .thumbnail>img {
    display: block;
    max-width: 100%;
    height: auto;
}
</style>