 <?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Cust_home/update_promocode');	?>
        <section class="content-header">
          <h1>
            Promo Code
          </h1>
         
        </section> 

		
	<!----------------------AMIT KAMBLE---LICENSE EXPIRY------------------------------------------------>
	<?php if(date('Y-m-d') > $_SESSION['Expiry_license']  ){ ?>
	<script>
			BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'Company work in progress... Will be up soon...Sorry for the inconvenience!',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/home';
				}
			}]
		});
		runjs(Title,msg);
	</script>
<?php } ?>
<!------------------------------------------------------------------------------------------------------->

			<?php
			if(@$this->session->flashdata('error_promo'))
			{
				?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('error_promo'); ?>';
					runjs(Title,msg);
				</script>
				<?php
			}
			?>
			<?php 
			
			
			if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
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
				<form action="#" method="post">
				 <div class="form-group has-feedback">
						<label for="exampleInputEmail1"> Enter Promocode</label>
						<input type="text" name="promo_code" id="promo_code" class="form-control" placeholder="Enter Promocode" required onchange="check_promo_code();"/>						
						<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
						<div class="help-block"></div>
					</div>
				 
				  <div class="row">
					
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat" onclick="check_promo_code();">Submit</button>
						<input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
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
	  <script>
			// $('#promo_code').change(function()
			function check_promo_code()
			{	
				// alert();
				var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
				var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
				var membership_id = '<?php echo $Enroll_details->Card_id; ?>';
				var Currentbalance = '<?php echo $Enroll_details->Current_balance; ?>';
				var promo_code = $('#promo_code').val();
				
				if( $("#promo_code").val() == "" )
				{
					has_error(".has-feedback","#glyphicon",".help-block","Please Enter Valid Promo Code..!!");
				}
				else
				{
					$.ajax({
						type: "POST",
						data: { promo_code: promo_code, Company_id:Company_id,Enrollment_id: Enrollment_id,Current_balance:Currentbalance,membership_id:membership_id },
						url: "<?php echo base_url()?>index.php/Cust_home/check_promo_code",
						success: function(data)
						{
							// alert(data);
							if(data == 0)
							{
								$("#promo_code").val("");
								has_error(".has-feedback","#glyphicon",".help-block"," In-valid Promo Code..!!");
							}
							else
							{
								has_success(".has-feedback","#glyphicon",".help-block",data);
							}
						}
					});
				}
			}
	  </script>
