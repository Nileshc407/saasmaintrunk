<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			EDIT PRODUCT GROUP
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
					echo form_open('E_commerce/update_product_group',$attributes); ?>
					<div class="form-group">
						<label for="">Merchant Name</label>
						<select class="form-control" name="seller_id" ID="seller_id" >
							
							<?php
								$SellerID = $results->Seller_id;
							/* for artCafe to link product groups to link sellers **sandeep**13-03-2020***/
					
								foreach($Seller_array as $seller_val)
								{
									if($SellerID == $seller_val->Enrollement_id)
									{
										echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
									}
								}
								
								if($SellerID == $enroll && $Super_seller == 1)
								{
									echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
								}
							?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Product Group Name </label>
						<input class="form-control" type="text" name="product_group_name" id="product_group_name" placeholder="Enter product group name" value="<?php echo $results->Product_group_name; ?>" data-error="Please enter product group name" required="required">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div> 
					  <div class="form-buttons-w">
						<input class="form-control" type="hidden" name="Product_group_id" value="<?php echo $results->Product_group_id; ?>" />
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
			  </div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Active Product Group
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Product Group ID</th>
								<th>Product Group Name</th>
								<th>Status</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Product Group ID</th>
								<th>Product Group Name</th>
								<th>Status</th>
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
									<a href="<?php echo base_url()?>index.php/E_commerce/edit_product_group/?Product_group_id=<?php echo $row->Product_group_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								
									
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Product_group_id;?>','<?php echo $row->Product_group_name; ?>','Product brands and Merchandise items linked to this product group will be made inactive','E_commerce/delete_product_group/?Product_group_id');" data-target="#deleteModal" data-toggle="modal"  title="Delete">
									<i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->Product_group_id;?></td>
								<td><?php echo $row->Product_group_name;?></td>
								<td>Active</td>
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
	if( $('#product_group_name').val() != "" )
	{
		show_loader();
		return true;
	}
});

$('#product_group_name').blur(function()
{ 
	if( $("#product_group_name").val() != "" )
	{
		var product_group_name = $("#product_group_name").val();
		
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {productGroupName: product_group_name, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/E_commerce/Check_product_group_name",
			  success: function(data)
			  {
					if(data == 1)
					{
						$("#product_group_name").val("");
						var msg1 = 'Already exist';
						$('.help-block').show();
						$('.help-block').html(msg1);
						$("#product_group_name").addClass("form-control has-error");
						return false; 
					}
					else
					{
						$("#product_group_name").removeClass("has-error");
						$('.help-block').html("");
					}
			  }
		});
	}
	else
	{
		$("#product_group_name").val("");
		var msg1 = 'Please enter product group name';
		$('.help-block').show();
		$('.help-block').html(msg1);
		$("#product_group_name").addClass("form-control has-error");
		return false;
	}
});
$(".alert").alert('close');
</script>