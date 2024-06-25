<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				PAYMENT TYPE MASTER
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
					}
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
					
					
					<?php  $attributes = array('id' => 'formValidate');
						echo form_open('Masterc/paymenttype',$attributes); ?>
						
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Payment Type</label>
						<input class="form-control" type="text" name="Payment_type" id="Payment_type" placeholder="Enter payment type" data-error="Please enter payment type" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block"></div>
					  </div>
					  
					  <div class="form-group"> 
						<label><span class="required_info">* </span>Payment Description</label>
						<textarea class="form-control" rows="3" name="Payment_description" id="Payment_description" placeholder="Enter payment type description" data-error="Please enter payment type description" required="required"></textarea>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-buttons-w">
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
					Payment Type Details
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>ID</th>
								<th>Payment Type</th>
								<th>Payment Type Description</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>ID</th>
								<th>Payment Type</th>
								<th>Payment Type Description</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results != NULL)
						{
							foreach($results as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Masterc/edit_paymenttype/?Payment_type_id=<?php echo $row->Payment_type_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								<td><?php echo $row->Payment_type_id;?></td>
								<td><?php echo $row->Payment_type;?></td>
								<td><?php echo $row->Payment_description;?></td>
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
	if( $('#Payment_type').val() != "" && $('#Payment_description').val() != "" )
	{
		show_loader();
		return true;
	}
});

$('#Payment_type').blur(function()   
{	
	if($("#Payment_type").val() == "")
	{
		var msg = 'Please enter user type';
		$('#help-block').show();
		$('#help-block').html(msg);
		$("#Payment_type").addClass("form-control has-error");
		return false;
	}
	else
	{
		var Payment_type = $("#Payment_type").val();
		$.ajax({
			  type: "POST",
			  data: {Payment_type: Payment_type},
			  url: "<?php echo base_url()?>index.php/Masterc/check_paymenttype",
			success: function(data)
			{
				if(data== 1)
				{
					$("#Payment_type").val("");
					$('#help-block').show();
					$('#help-block').html("Already exist");
					$("#Payment_type").addClass("form-control has-error");
				}
				else
				{
					$("#Payment_type").removeClass("has-error");
					$("#help-block").html("");
				}	
			}
		});
	}	
});
</script>