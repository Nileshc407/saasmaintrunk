<?php $this->load->view('header/header'); ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   MERCHANT CATEGORY
			  </h6>
			  <div class="element-box">
			  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('success_code'); $this->session->unset_userdata('data_code');

				} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php 	$this->session->unset_userdata('error_code'); $this->session->unset_userdata('data_code');
				} ?>
				
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Masterc/merchant_category',$attributes); ?>
				<div class="row">
					<div class="col-sm-6">	
					<div class="form-group">
					<label for=""> <span class="required_info">* </span> Company Name </label>
					<select class="form-control" name="companyId"  id="companyId" required="required">

					 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
					</select>
					</div>		  		
								  
				 <div class="form-group">
					<label for=""> <span class="required_info">* </span> Merchant Name </label>
					<select class="form-control" name="sellerId" id="sellerId" required="required" data-error="Please select merchant name">
					<option value="">Select Merchant</option>
					<option value="0">All Merchants</option>
					  <?php
							foreach($company_sellers as $val)
							{
								echo '<option value="'.$val->Enrollement_id.'">'.$val->First_name." ".$val->Last_name.'</option>';
							}
						?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div>
				  
				  <div class="form-group">
					<label for=""> <span class="required_info">*</span> Merchant Category Code </label>								
					<input class="form-control"  name="item_type_no" id="item_type_no"  type="text"  placeholder="Enter Merchant Category Code"  required="required" data-error="Please enter merchant category code">
					<div class="help-block form-text with-errors form-control-feedback" id="merchant_code"></div>
				  </div> 
				  
					<div class="form-group">
					<label for=""> <span class="required_info">*</span> Merchant Category Name </label>								
					<input class="form-control"  name="item_type_name" id="item_type_name"  type="text"  placeholder="Enter Merchant Category Name"  required="required" data-error="Please enter merchant category name">
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div> 
				  </div>		  				  		
				  <div class="col-sm-6">
				   <div class="form-group">
					<label for=""> Merchant Category Description </label>								
					<textarea class="form-control" rows="11" name="item_desc" id="item_desc"  type="text"  placeholder="Enter Merchant Category Description"></textarea>

					</div> 
				  </div> 
				</div> 

				  <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>
			</div>
			<!-------------------- START - Data Table -------------------->
	           
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Merchant Category Items
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th class="text-center">Action</th>
								<th class="text-center">Merchant Name</th>
								<th class="text-center">Category Code</th>
								<th class="text-center">Category Name</th>
								<th class="text-center">Description</th>
											
							</tr>
						</thead>	
						<tfoot>
							<tr>
								<th class="text-center">Action</th>
								<th class="text-center">Merchant Name</th>
								<th class="text-center">Category Code</th>
								<th class="text-center">Category Name</th>
								<th class="text-center">Description</th>
							</tr>
						</tfoot>		

						<tbody>
							<?php
							if($results != NULL)
							{
								foreach($results as $row)
								{
								?>
									<tr>
										<td class="row-actions">
											<a href="<?php echo base_url()?>index.php/Masterc/edit_merchant_category/?Item_category_id=<?php echo $row->Item_category_id;?>" title="Edit">
												<i class="os-icon os-icon-ui-49"></i>
											</a>
										</td>		
										<td><?php echo $row->First_name." ".$row->Last_name; ?></td>
										<td><?php echo $row->Item_type_code; ?></td>
										<td><?php echo $row->Item_category_name; ?></td>
										<td><?php echo $row->Item_typedesc; ?></td>
									</tr>
								<?php
								}
							}
							?>				
				</tbody> 
					</table>
				  </div>
				</div>
			  </div>
	
<!--------------------  END - Data Table  -------------------->

		  </div>
		</div>
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>

<script>
	
	$('#Register').click(function()
	{
			
		if( $('#companyId').val() != "" && $('#sellerId').val() != "" && $('#item_type_no').val() != "" && $('#item_type_name').val() != "" )
		{
			show_loader();
		}
	});
	
	$('#item_type_no').blur(function()
	{						
		if( $("#sellerId").val() != "")
		{
			if($("#item_type_no").val() == "")
			{
				//has_error(".has-feedback","#glyphicon",".help-block","Please Enter Item Type Code");
				
				var msg1 = 'Please enter merchant category code';
				$('#merchant_code').show();
				$('#merchant_code').html(msg1);
				$("#item_type_no").addClass("form-control has-error");
			}
			else
			{
				var Item_category_code = $("#item_type_no").val();
				var Company_id = $("#companyId").val();
				var Seller_id = $("#sellerId").val();
				$.ajax({
					type: "POST",
					data: {Item_category_code: Item_category_code, Company_id: Company_id, Seller_id: Seller_id},
					url: "<?php echo base_url()?>index.php/Masterc/check_item_code",
					success: function(data)
					{		
						 //alert(data.length);
						if(data.length > 27)
						{
							// alert("Exist-------"+data.length);
							$("#item_type_no").val("");
							//has_error(".has-feedback","#glyphicon",".help-block",data);
							$("#item_type_no").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#merchant_code').show();
							$('#merchant_code').html(msg1);
						}
						else
						{
							$('#merchant_code').html("");
							$("#item_type_no").removeClass("has-error");	
						}
						
					}
				});
			}
		}
		else
		{
			$("#item_type_no").val("");
			
			var msg1 = 'Please select seller first';
				$('#merchant_code').show();
				$('#merchant_code').html(msg1);
				$("#item_type_no").addClass("form-control has-error");
		}
	});

</script>