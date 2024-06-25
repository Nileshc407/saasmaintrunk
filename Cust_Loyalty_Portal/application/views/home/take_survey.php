<html>
<head>
	<?php /* <link href="http://localhost/ci_igainspark/assets/Customer_assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="http://localhost/ci_igainspark/assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />	
	<script type="text/javascript" src="http://localhost/ci_igainspark/assets/bootstrap-dialog/js/alert_function.js"></script>			
	<script src="http://localhost/ci_igainspark/assets/js/jquery.min.js"></script>
	<script src="http://localhost/ci_igainspark/assets/js/bootstrap.js"></script>
	<script src="http://localhost/ci_igainspark/assets/js/common.js"></script>	
	<script src="http://localhost/ci_igainspark/assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>*/ ?>

	<link rel="shortcut icon" href="<?php echo $this->config->item('base_url2')?>images/logo_igain.ico" type="image/x-icon">
	<link href="<?php echo $this->config->item('base_url2')?>assets/css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('base_url2')?>assets/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo$this->config->item('base_url2')?>assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/bootstrap.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/common.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/alert_function.js"></script>
	
	

	<script type="text/javascript">
		$(document).ready(function ()
		{  
			$('.dropdown-toggle').dropdown(); 
			
			$(".launch-modal").click(function()
			{
				$("#myModal").modal({
					backdrop: 'static'
				});
			});
		});		
	</script>
	
	
	<?php 	
	echo form_open_multipart('Cust_home/getsurveyquestion');	
	if(@$this->session->flashdata('survey_feed'))
	{		
	?>
	
		
		<script>
		
			/* var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('survey_feed'); ?>';
			runjs(Title,msg); */
			/* var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('survey_feed'); ?>';
			buttons: [{
					label: 'OK',
					action: function(dialog)
					{
						if(Flag == 2)
						{
							window.location='new_cust_notification.php';
						}
						else
						{
							window.close();
						}
					}
				}]
			runjs(Title,msg); */
			
			function runjs()
			{
				BootstrapDialog.show({
					closable: false,
					title: 'Application Information',
					message: '<?php echo $this->session->flashdata('survey_feed'); ?>',
					buttons: [
					{
						label: 'OK',
						action: function(dialog)
						{
							window.close();							
						}
					}]
				});									
				// document.getElementById("wrapper").style.display = "none";
			}
				
			$( document ).ready(function() {
				runjs();
			});
		</script>
	<?php
	}				 			
	?>
	</head>
		<?php 
		
			$Survey_data = json_decode( base64_decode($_REQUEST['Survey_data']) );
			$Survey_data = get_object_vars($Survey_data);					
			if($Survey_data['Card_id'] == '0' || $Survey_data['Card_id']== ""){ ?>
			<script>
					BootstrapDialog.show({
					closable: false,
					title: 'Application Information',
					message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
					buttons: [{
						label: 'OK',
						action: function(dialog) {
							window.close();	
						}
					}]
				});
				runjs(Title,msg);
			</script>
		<?php } ?>
	<body>
		<div class="content-wrapper">
			<div class="container">
				
				<?php if($Survey_response_count==0) { ?>
				<div class="row">
				
					<div class="col-md-6 col-md-offset-3">
				
						<div class="panel panel-info">                        
				
							<div class="panel-heading">
								<h4 class="text-center">We value your feedback as it helps us to serve you better. So please do answer all the Questions!!</h4>
							</div>
							
							<div class="panel-body">
								
								<?php 
								if($Survey_response_count==0)
								{
									$Survey_data = json_decode( base64_decode($_REQUEST['Survey_data']) );
									$Survey_data = get_object_vars($Survey_data);
									$survey_id = $Survey_data['Survey_id'];
									$gv_log_compid = $Survey_data['Company_id'];
									$Enrollment_id = $Survey_data['Enroll_id']; 
									$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id);
									$Survey_data1 = base64_encode(json_encode($myData1));
									$i=1;
									
									if($Survey_details)
									{
										foreach($Survey_details as $surdtls)
										{
											$Question_id=$surdtls['Question_id'];							 
											// $Question_array[]=$surdtls['Question_id'];							 
											?>
											<div class="form-group has-feedback">
												<?php if($surdtls['Response_type']==2 ) { ?>
												 <b><?php echo $i.'.     '. $surdtls['Question']; ?></b>	
													<!--<input type="text" class="form-control" name="<?php echo $Question_id; ?>">-->
												<textarea class="form-control" rows="3" name="<?php echo $Question_id; ?>"  id="currentAddress" required  ></textarea> 
												
												<?php } 
												else if($surdtls['Response_type']==1 ) 
												{ 
													$Choice_id=$surdtls['Choice_id'];
												?>
														
													<b><?php echo  $i.'.     '.$surdtls['Question']; ?></b>
													<br><br>
													<?php
													$ci_object = &get_instance();
													$ci_object->load->model('Survey_model');								
													$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
													if($choice_values)
													{
														foreach($choice_values as $ch_val)
														{
															?>
															<label class="radio-inline">
																<input type="radio"  name="<?php echo $Question_id; ?>"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" required><?php echo $ch_val['Option_values']; ?>
															</label><br>
														<?php 
														}
													}								
												} 
												?>
											</div>
											
										<?php 
										$i++;
										}				
									}
								}
								?>
								
							</div>
							
							<div class="panel-footer text-center">
								<button type="submit" class="btn btn-primary" >Submit</button>
								<input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>" />
								<input type="hidden" name="compid" value="<?php echo $gv_log_compid; ?>" />
								<input type="hidden" name="Enrollment_id" value="<?php echo $Enrollment_id; ?>" />
								<input type="hidden" name="Survey_data" value="<?php echo $Survey_data1; ?>" />
								<input type="hidden" name="flag" value="1" />
							</div>
							
						</div>		
						
					</div>				
				
				</div>
				<?php }	else { ?>
				
					<script>
						function runjs()
						{
							BootstrapDialog.show({
								closable: false,
								title: 'Application Information',
								message: 'Sorry, it seems you have already given the survey or you do not have any survey. Contact Customer Service!',
								buttons: [
								{
									label: 'OK',
									action: function(dialog)
									{
										window.close();
									}
								}]
							});									
							// document.getElementById("wrapper").style.display = "none";
							$('.content-wrapper').hide();
						}	
							
						$( document ).ready(function() {
							runjs();
						}); 
					</script>
				<?php } ?>
				
			</div>
		</div>
	</body>	
	
	<?php /*
		<body class="hold-transition register-page">		
		<div class="register-box">
		<div class="register-logo">
		<?php if($Survey_response_count==0)
		{
			?>
			<div class="small-box" style="background-color: rgb(49, 133, 156) ! important;">
				<div class="inner" style="padding: 5px;">					
						<h4 class="text-center" style="margin: 3px;color: #fff;">We value your feedback as it helps us to serve you better. So please do answer all the Questions!!</h4>
				</div>
			</div>
			<?php 
					}
					else
					{
						?>	
						<script>
							function runjs()
							{
									BootstrapDialog.show({
											closable: false,
											title: 'Application Information',
											message: 'Sorry, it seems you have already given the survey or you do not have any survey. Contact Customer Service!',
											buttons: [{
												label: 'OK',
												action: function(dialog)
												{
													
														window.close();
													
												}
											}]
										});									
										document.getElementById("wrapper").style.display = "none";
								}								
								$( document ).ready(function() {
									runjs();
								}); 
							
						 
							</script>
						<?php
					}
					?>
		</div>			
		<div class="register-box-body">
			<form action="#" method="post">
<?php 
// var_dump($Survey_response_count);

if($Survey_response_count==0)
{
				$Survey_data = json_decode( base64_decode($_REQUEST['Survey_data']) );
				$Survey_data = get_object_vars($Survey_data);
				$survey_id = $Survey_data['Survey_id'];
				$gv_log_compid = $Survey_data['Company_id'];
				$Enrollment_id = $Survey_data['Enroll_id']; 
				$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id);
				$Survey_data1 = base64_encode(json_encode($myData1));
				$i=1;
				if($Survey_details)
				{
					foreach($Survey_details as $surdtls)
					{
						$Question_id=$surdtls['Question_id'];							 
						// $Question_array[]=$surdtls['Question_id'];							 
						?>
						<div class="form-group has-feedback">
							<?php if($surdtls['Response_type']==2 ) { ?>
							 <b><?php echo $i.'.     '. $surdtls['Question']; ?></b>	
								<!--<input type="text" class="form-control" name="<?php echo $Question_id; ?>">-->
								<textarea class="form-control" rows="3" name="<?php echo $Question_id; ?>"  id="currentAddress" required  ></textarea> 
							
							<?php } 
							else if($surdtls['Response_type']==1 ) 
							{ 
								$Choice_id=$surdtls['Choice_id'];
								?>
									
								 <b><?php echo  $i.'.     '.$surdtls['Question']; ?></b>
								 <br>
								<?php
								$ci_object = &get_instance();
								$ci_object->load->model('Survey_model');								
								$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
								if($choice_values)
								{
									foreach($choice_values as $ch_val)
									{
										?><br>
											<label class="radio-inline">
												<label class="radio-inline">
											<input type="radio"  name="<?php echo $Question_id; ?>"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" required><?php echo $ch_val['Option_values']; ?>
										</label>
												
											</label>										
									<?php 
									}
								}								
							?>
					<?php  } ?>
						</a>
						</div>						
			<?php 
			$i++;
			}				
			}			
			?>
				<button type="submit" class="btn btn-primary" >Submit</button>
				<input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>" />
				<input type="hidden" name="compid" value="<?php echo $gv_log_compid; ?>" />
				<input type="hidden" name="Enrollment_id" value="<?php echo $Enrollment_id; ?>" />
				<input type="hidden" name="Survey_data" value="<?php echo $Survey_data1; ?>" />
				<input type="hidden" name="flag" value="1" />
			</form>
<?php } ?>
		</div><!-- /.form-box -->
    </div><!-- /.register-box -->   
        <?php echo form_close(); ?>
		<?php //$this->load->view('header/loader');?> 
		<?php //$this->load->view('header/footer');?>	 
		</div>
	
			
	</div>
	
</body>*/ ?>
</html> 

<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/css/bootstrap.min.css">



<style>		
.login-box-body{
background:none;
}
.login-box, .register-box
{
	 width: 50%;
    margin: 2% auto;
}
.register-page
{
	min-height:80%;
}
.main-footer
{
	margin-left:0;
}
/* .form-control
{
	width: 53%;
} */
</style>
	
	