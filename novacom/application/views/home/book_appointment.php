 <?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Cust_home/insert_booking_appointment');	?>
        <section class="content-header">
          <h1>
            Service Booking Appointment
          </h1>
         
        </section>

		<?php
			if(@$this->session->flashdata('booking_success'))
			{
				?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('booking_success'); ?>';
					runjs(Title,msg);
				</script>
				<?php
			}
			?>
			<?php 
			if($Enroll_details->Card_id == 0 || $Enroll_details->Card_id== "") { ?>
				<script>
						BootstrapDialog.show({
						closable: false,
						title:'Application Information',
						message:'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
						buttons:[{
							label: 'OK',
							action: function(dialog) {
								window.location='<?php echo base_url()?>index.php/Cust_home/home';
							}
						}]
					});
					runjs(Title,msg);
				</script>
			<?php } ?>
        <!-- Main content -->
        <section class="content">
        <div class="row">
			
			<div class="login-box">
			  <div class="login-box-body">
				<p class="login-box-msg"> </p>
				<form action="#" method="POST">
					<div class="form-group has-feedback">
						<input type="text" name="vehicle_no"  class="form-control" placeholder="Enter vehicle number" style="text-transform:uppercase">
						<span><?php echo form_error('Vehicle_no'); ?></span>
					</div>
					<div class="form-group has-feedback">							
						<select class="form-control user-success" name="Car_brand" >
							<option value="">Select Car Brand </option>
							<option value="Volkswagen">Volkswagen</option>
							<option value="Renault">Renault</option>
						</select>							
					</div>
					<div class="form-group has-feedback">
						<input type="text" name="appointment_date"  class="form-control" id="datepicker"  placeholder="Appointment Date" required>
						<span><?php echo form_error('appointment_date'); ?></span>
					</div>					
					<div class="form-group has-feedback">							
						<select class="form-control user-success" name="Seller_id" required="">
							<option value="">Select Service Outlet </option>
							<?php foreach($FetchSellerdetails as $seller) { ?>
								<option value="<?php echo $seller['Enrollement_id']; ?>">VW-<?php echo $seller['First_name'].' '.$seller['Last_name'] ?></option>
							<?php } ?>
						</select>							
					</div>
				  <div class="row">					
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
						<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
						<input type="hidden" name="email" value="<?php echo $Enroll_details->User_email_id; ?>" class="form-control" />
						<input type="hidden" name="phone_no" value="<?php echo $Enroll_details->Phone_no; ?>" class="form-control" />
						<input type="hidden" name="customer_name" value="<?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?>" class="form-control" />
						<input type="hidden" name="from_app" value="1" class="form-control" />
					</div><!-- /.col -->
				  </div>
				</form>


			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
			
         </div><!-- /.row -->
		<?php echo form_close(); ?>
        </section><!-- /.content -->
		<?php $this->load->view('header/loader');?> 
      <?php $this->load->view('header/footer');?>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>	  
	  <script>
	  
	  
	$(function () 
	{
		$("#datepicker").datepicker({
		minDate: 0,
		changeMonth: true,
		yearRange: "-80:+5",
		changeYear: true
		});
	});
	</script>
