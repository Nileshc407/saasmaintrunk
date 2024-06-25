<?php $this->load->view('header/header'); ?>
<div class="content-i" style="min-height: 800px;">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				ASSIGN MEMBERSHIP ID
			  </h6>
			   <div class="element-box" >
				  <div class="col-sm-8">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			  <?php 	$this->session->unset_userdata('success_code');
					} 
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} 
						$attributes = array('id' => 'formValidate');
						
						echo form_open('Enrollmentc/asign_membership',$attributes); 
				?>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Enter Name or Phone No. <span class="required_info">(Please Enter Phone No. without '+' and country code)</span></label>
						<input class="form-control" type="text" name="fname" id="fname" placeholder="Enter member name or phone no." data-error="Please enter member name or phone no." required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div> 
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					 <?php echo form_close(); ?>		  
				   </div>
			   </div>
			</div>
		  </div>
		</div>
	</div>	
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	if($('#fname').val() != "")
	{
		 show_loader();
		return true;
	}
});

$('#fname').blur(function()
{
	if( $("#fname").val() == "" )
	{
		var msg = 'Please enter valid name or phone no.';
		$('#help-block1').show();
		$('#help-block1').html(msg);
		$("#fname").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block1').hide(); }, 3000);
	}
	else
	{
		$("#fname").removeClass("has-error");
		$("#help-block1").html("");
	}
});
</script>