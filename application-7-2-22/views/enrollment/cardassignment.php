<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   ASSIGN MEMBERSHIP CARD
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
						$this->session->unset_userdata('success_code');
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
					echo form_open_multipart('Enrollmentc/asign_membership_card/?Enrollment_id='.$results->Enrollement_id.'&Refrence_Enrollment_id='.$results->Refrence,$attributes); ?>
					
					  <div class="form-group">
						<label for=""><span class="required_info" style="color:red;">* </span>Assign Membership ID</label><input class="form-control" data-error="Please enter membership id" placeholder="Enter membership id"  type="text" name="CardID" id="cardId" required="required" maxlength="16">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>  
					  
					  <div class="form-group">
						<label for=""> Member Name</label>
						<input class="form-control" readonly type="text" name="Name" id="Name" value="<?php echo $results->First_name.' '.$results->Last_name; ?>">
					  </div>
					  
					  <div class="form-group">
						<label for=""> Phone No.</label>
						<input class="form-control" type="text" name="phno" id="phno" readonly value="<?php echo App_string_decrypt($results->Phone_no); ?>" placeholder="Enter Phone No">
					  </div>   	
					  
					  <div class="form-group">
						<label for=""> User Email Address</label>								
						<input class="form-control" placeholder="User Email ID" name="userEmailId" id="userEmailId"  type="email" readonly value="<?php echo App_string_decrypt($results->User_email_id); ?>" placeholder="User Email address"/>
					  </div>
					  
					 <div class="form-group">
						<label for=""> Date of Birth</label>
						<input class="form-control" type="text" name="dob" id="dob" readonly id="datepicker" value="<?php echo $results->Date_of_birth; ?>" placeholder="Enter Date of Birth"/>
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
	if($('#cardId').val() != "")
	{
		 show_loader();
		return true;
	}
});

$('#cardId').blur(function()
{
	if( $("#cardId").val()  == "" )
	{	
		var msg = 'Please enter valid membership id.';
		$('.help-block').show();
		$('.help-block').html(msg);
		$("#cardId").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	else
	{
		var cardId = $("#cardId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			  type: "POST",
			  data: {cardid: cardId, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_card_id",
			  success: function(data)
			  {
				if(data.length == 13)
				{
					$('#cardId').val('');
					var msg = 'Membership id Is Already Assigned.';
					$('.help-block').show();
					$('.help-block').html(msg);
					$("#cardId").addClass("form-control has-error");
					// setTimeout(function(){ $('.help-block').hide(); }, 3000);
					return false;
				}
				else
				{
					$("#cardId").removeClass("has-error");
					$(".help-block").html("");
					// has_success(".has-feedback","#glyphicon",".help-block",data);
					return true;
				}
			  }
		});
	}
});	

$('#cardId').bind("cut copy paste",function(e) {
  e.preventDefault();
});
</script>