<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT PRODUCT SUB GROUP
			  </h6>
			  <div class="element-box panel">
				<div class="col-sm-8">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 		
					} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
					<?php 	} ?>
					
					<?php $attributes = array('id' => 'formValidate');
						echo form_open('E_commerce/update_product_brand',$attributes); ?>
					 <div class="form-group">
						<label for=""> Select Product Group</label>
						<input class="form-control" type="text" name="product_group" id="product_group" value="<?php echo $results->Product_group_name; ?>" readonly="readonly"/>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""><span class="required_info" style="color:red;">* </span>Product SUB GROUP </label>
						<input class="form-control" type="text" name="product_brand_name" id="product_brand_name" placeholder="Enter product sub group" data-error="Please product sub group" value="<?php echo $results->Product_brand_name; ?>" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div> 
						
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
						<input type="hidden" name="Product_brand_id" value="<?php echo $results->Product_brand_id; ?>" />
						
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
			  </div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Product Sub Group
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Product Sub Group ID</th>
								<th>Product Group Name</th>
								<th>Product Sub Group</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Product Sub Group ID</th>
								<th>Product Group Name</th>
								<th>Product Sub Group</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results2 != NULL)
						{
							foreach($results2 as $row)
							{
								
						?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/E_commerce/edit_product_brand/?Product_brand_id=<?php echo $row->Product_brand_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Product_brand_id;?>','<?php echo $row->Product_brand_name; ?>','Merchandise items linked to this product brands will be made inactive','E_commerce/delete_product_brand/?Product_brand_id');"  data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->Product_brand_id;?></td>
								<td><?php echo $row->Product_group_name;?></td>
								<td><?php echo $row->Product_brand_name;?></td>
							</tr>
				<?php 		}
						}	?>
						</tbody>
					</table>
				  </div>
				</div>
			</div>
			<!--------------Table--------------->
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	if( $('#product_brand_name').val() != "" && $('#product_group').val() != "" )
	{
		show_loader();
		return true;
	}
});
$('#product_brand_name').blur(function()
{ 
	if( $("#product_brand_name").val() != "" )
	{
		var product_brand_name = $("#product_brand_name").val();
		
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {product_brand_name: product_brand_name, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/E_commerce/Check_product_brand_name",
			  success: function(data)
			  {
					if(data == 1)
					{
						$("#product_brand_name").val("");
						var msg1 = 'Already exist';
						$('#help-block1').show();
						$('#help-block1').html(msg1);
						$("#product_brand_name").addClass("form-control has-error");
						return false; 
					}
					else
					{
						$("#product_brand_name").removeClass("has-error");
						$('#help-block1').html("");
					}
			  }
		});
	}
	else
	{
		$("#product_brand_name").val("");
		var msg1 = 'Please enter product sub group name';
		$('#help-block1').show();
		$('#help-block1').html(msg1);
		$("#product_brand_name").addClass("form-control has-error");
		return false;
	}
});
</script>