<?php  
// $smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
echo form_open_multipart('Cust_home/getsurveyquestion2');

		if(@$this->session->flashdata('survey_feed'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('survey_feed'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}				 			
			?>
<section class="content-header">
	<h1>Take Survey</h1>  
</section>
<section class="content">
	<div class="register-box">
		<div class="register-logo">
			<div class="small-box" style="background-color: rgb(49, 133, 156) ! important;">
				<div class="inner" style="padding: 5px;">
					<?php if($Survey_response_count==0)
					{
						?>
						<h4 class="text-center" style="margin: 3px;color: #fff;">We value your feedback as it helps us to serve you better. So please do answer all the Questions!!</h4>
						<?php 
					}
					else
					{
					?>
					<h4 class="text-center" style="margin: 3px;color: #fff;">Sorry! It Seems you have already taken Survey OR Please Contact Customer Service </h4>
					<?php
					}
					?>
				</div>
			</div>
		</div>			
		<div class="register-box-body">
			<form action="#" method="post">
<?php 

if($Survey_response_count==0)
{
				$i=1;
				if($Survey_details)
				{
					foreach($Survey_details as $surdtls)
					{
						$Question_id=$surdtls['Question_id'];							 
						$survey_id=$surdtls['Survey_id'];							 
						$Company_id=$surdtls['Company_id'];							 
						?>
						<div class="form-group has-feedback">
							<?php if($surdtls['Response_type']==2 ) { ?>
							 <b><?php echo $i.'.     '. $surdtls['Question']; ?></b>	
								<!--<input type="text" class="form-control" name="<?php echo $Question_id; ?>"> -->
								<textarea class="form-control" rows="3" name="<?php echo $Question_id; ?>"  id="currentAddress" required  ></textarea>
							
							<?php } 
									else if($surdtls['Response_type']==1 ) 
									{ 
								$Choice_id=$surdtls['Choice_id'];
								?>
									
								<b><?php echo  $i.'.     '.$surdtls['Question']; ?></b>
								
								<?php
								$ci_object = &get_instance();
								$ci_object->load->model('Survey_model');
								
								$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
								foreach($choice_values as $ch_val)
								{
									?><br>
										<label class="radio-inline">
											<input type="radio"  name="<?php echo $Question_id; ?>"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" required><?php echo $ch_val['Option_values']; ?>
										</label>
										
								<?php 
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
				<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
				<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
			</form>
	<?php } ?>
		</div><!-- /.form-box -->
    </div><!-- /.register-box --> 
	
</section>		
		 
<?php echo form_close(); ?>
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>	  
<style type="text/css">
.demo { position: relative; }
.demo i { position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;}
.login-box, .register-box { margin:2% auto;}	  
.dropdown-menu{cursor: pointer !Important;}
.day{background-color: #fff;border-color: #3071a9;color: #000;border-radius:4px;}	 
.login-box, .register-box{
width:100%;
}
</style>

<?php  
?>





		<?php /* $this->load->view('header/header');?>
		<?php echo form_open_multipart('Cust_home/getsurveyquestion2'); 
		
			if(@$this->session->flashdata('survey_feed'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('survey_feed'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}				 			
			?>
        <section class="content-header">
          <h1>
           Take Survey
            <small></small>
          </h1>         
        </section>
		
        <!-- Main content -->
        <section class="content">
		
			<?php if($Survey_response_count==0)
			{
			?>
			<div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Survey Questions</h3>                 
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                     
					  <tbody>
							 <?php 
						if($Survey_response_count==0)
						{
							$i=1;
							if($Survey_details)
							{
								foreach($Survey_details as $surdtls)
								{
									$Question_id=$surdtls['Question_id'];							 
									$survey_id=$surdtls['Survey_id'];							 
									$Company_id=$surdtls['Company_id'];							 
									if($surdtls['Response_type']==2 ) 
									{ 
									?>								
									<tr>							
										<td>
											<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $i.'.     '. $surdtls['Question']; ?></div>
											<input type="text" class="form-control" name="<?php echo $Question_id; ?>"> 
										</td>
									</tr>	
								  <?php 
									} 
									else if($surdtls['Response_type']==1 ) 
									{ 
										$Choice_id=$surdtls['Choice_id'];
										?>
											
										 <?php echo  $i.'.     '.$surdtls['Question']; 
										 
										$ci_object = &get_instance();
										$ci_object->load->model('Survey_model');
										
										$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
										foreach($choice_values as $ch_val)
										{
											?>
													<input type="radio"  name="<?php echo $Question_id; ?>"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" ><?php echo $ch_val['Option_values']; ?>
												
												
										<?php 
										}							
								} 
							}
						}
						}
						?>							  
						  </tbody>                     
                    </table>
                  </div>
                </div> 							
			</div>	
			<?php }
			 else
			 {
			?>
			<div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Sorry! It Seems you have already taken Survey OR Please Contact Customer Service</h3>                 
                </div>
                							
			</div>	
			<?php } ?>
		</section>
	
	

	 <?php echo form_close(); ?>
	<?php $this->load->view('header/footer'); */
	
	?>