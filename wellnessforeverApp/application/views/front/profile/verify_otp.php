<?php $this->load->view('front/header/header'); ?>
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url();?>index.php/Cust_home/Verify_email"><span>OTP</span></a>
				</div>
			</div>
		</div>
	</header>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-12" style="height: 22px;"></div>
				<div class="col-12 d-flex justify-content-between align-items-center hedMain">
					<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/Verify_email';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
					<div><h1>OTP</h1></div>
					<div class="leftRight"><!--<button><img src="<?php echo base_url(); ?>assets/img/edit-icon.svg"></button>--></div>
				</div>
			</div>
		</div>
	</header>
	
	<main class="padTop padBottom">
		<div class="container">
				<div class="row">
				<?php
				if(@$this->session->flashdata('error_code'))
				{
				?>
					<div class="alert bg-danger alert-dismissible" id="msgBox" role="alert" style="margin-left: 50px;">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h6 class="form-label text-white"><?php echo $this->session->flashdata('error_code'); ?></h6>
					</div>
				<?php
					}
				?>
				</div>
				<?php echo form_open_multipart('Cust_home/Verifiy_pin'); ?>
				
					<div class="col-12 perDetailsWrapper">	
						<div class="form-group">
							<label class="font-weight-bold">Enter OTP</label>
							<input type="text" class="form-control" name="Pin" id="Pin" maxlength="4" required onkeyup="this.value=this.value.replace(/\D/g,'')">
							<div class="line"></div>
							<div class="help-block" style="float: center;"></div>
						</div>							
						<button type="submit" class="redBtn w-100 text-center" >Submit</button>
						
					</div>
				
				<?php echo form_close(); ?>
			
		</div>
	</main>
	<?php echo $Enroll_details->Enrollement_id; ?>
	
<?php $this->load->view('front/header/footer'); ?> 

 
	

<script type="text/javascript">
	
/* function Verifiy_pin()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollement_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var Pin = $('#Pin').val();
	var Pin_length = Pin.length;
	if(Pin_length !=4)
	{
		var msg1 = 'Enter 4 digit code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	$.ajax({
		type: "POST",
		data: { Enrollement_id: Enrollement_id, Company_id:Company_id, Pin:Pin},
		url: "<?php echo base_url()?>index.php/Cust_home/Verifiy_pin",
		success: function(data)
		{				
			if(data == 0)
			{
				$("#Pin").val("");						
				var msg1 = 'Enter Valid Code';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
			}
			else
			{
				window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/profile?Verifiy=1";
			}
		}
	});
} */
   </script>