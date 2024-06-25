<?php 
$this->load->view('header/header');
// echo form_open_multipart('Cust_home/getsurvey');
echo form_open_multipart('Cust_home/getsurveyquestion');
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
		<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
			<script>
					BootstrapDialog.show({
					closable: false,
					title: 'Application Information',
					message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
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
<section class="content-header">
	<h1>Take Survey</h1>  
</section>
<section class="content">
	<div class="row">		
			<?php 			
			$all_survey=array();
			$all_check_survey=array();
			if($get_survey_details)
			{
				foreach($get_survey_details as $survey)
				{
					$all_survey[]=$survey['Survey_id'];
					if($survey['Survey_type']==1)
					{
						$Survey_type='Feedback Survey';
						
					}
					else if($survey['Survey_type']==2)
					{
						$Survey_type='Service Related Survey';
					}
					else if($survey['Survey_type']==3)
					{
						$Survey_type='Product Survey';
					}					
					$ci_object = &get_instance();
					$ci_object->load->model('Survey_model');
					$survey_total_response = $ci_object->Survey_model->Check_total_survey_response($Enroll_details->Company_id,$Enroll_details->Enrollement_id,$survey['Survey_id']);
					$all_check_survey[]=$survey_total_response->Survey_id;				
					$survey_response = $ci_object->Survey_model->Check_survey_response($Enroll_details->Company_id,$Enroll_details->Enrollement_id,$survey['Survey_id']);					
									
					// echo"--survey_response----".$survey_response->Survey_id."---<br>";
					if($survey_response==0)
					{
						$survey_question = $ci_object->Survey_model->Check_survey_question($Enroll_details->Company_id,$survey['Survey_id']);	
						// $all_check_survey[]=$survey['Survey_id'];
						// echo"--survey_question----".$survey_question."---<br>";
						if($survey_question >0)
						{
								
							?>				
							<div class="col-md-4">
								<div class="box box-widget widget-user-2">
									<div class="widget-user-header bg-green" style="background-color: #5e4103 !important;">
										<div class="widget-user-image">
											
										</div>
										<h3 class="widget-user-username" style="color: white !important;"><?php echo $survey['Survey_name']; ?></h3>
										
									</div>						
									<div class="box-footer no-padding">
										<ul class="nav nav-stacked">
											<?php if($survey['Survey_reward_points'] != '0' ) { ?>
												<li><a href="javascript:void(0);"><strong>Rewards <?php echo $Company_Details->Currency_name; ?> </strong> <span class="pull-right"><?php echo $survey['Survey_reward_points']; ?></span></a></li>
											<?php 
											}
											else 
											{ ?>
												<li><br></li>
												<li><br></li>
											<?php 
											}
											?>
											<li><a href="javascript:void(0);"><strong>Survey Type</strong> <span class="pull-right"><?php echo $Survey_type; ?></span></a></li>
											<li><br></li>
											<li><br></li>										
											<li>
												<button type="button" id="submit2" class="btn btn-primary btn-block btn-flat" onclick="return get_new_survey(<?php echo $survey['Survey_id']; ?>);" name="submit" >Take Survey</button>
											</li>
										</ul>
									</div>
								</div>
							</div>
						<?php
						}
						else
						{
							?>
						
								<div class="box-footer text-center">
									<a href="#" class="uppercase">It seems you have given the survey or you do not have any survey</a>
								</div>
						<?php
						}
					}	
				}
			}
			// print_r($all_survey);
			// print_r($all_check_survey);
			if($all_survey == $all_check_survey) 
			{
			 ?>
						
					<div class="box-footer text-center">
						<a href="#" class="uppercase">It seems you have given the survey or you do not have any survey</a>
					</div>
			<?php	
			}
			?>	
				<!--<div class="form-group has-feedback">
					<label for="exampleInputPassword1">Select Survey</label>
					<select class="form-control" name="Survey_id" id="Survey_id" onchange="get_new_survey(this.value);" >
						<option value="">Select Survey</option>
						<?php 											
						foreach($get_survey_details as $survey)
						{
							echo "<option  value=".$survey['Survey_id'].">".$survey['Survey_name']."</option>";
						}										
						?>
					</select>						
					<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
					<div class="help-block"></div>
				</div>-->

				
				<div class="row">				
					<div class="col-xs-12">	
						
						<!--<button type="submit" id="submit2" class="btn btn-primary btn-block btn-flat" name="submit" >Next</button>-->
						<input type="hidden" name="Enroll_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						  <input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						  <input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						  <input type="hidden" name="Card_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
					</div>
				</div>
			  
	</div>	
	
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
</style>
	
<script>
$("#submit2").click(function(){
	var Title = "Application Information";	
	if($("#Survey_id").val()=="")
	{
		var msg = 'Please Select Survey';
		runjs(Title,msg);
		return false;
	}
	
});

function get_new_survey(surID)
{
	 // alert('---surID---'+surID);
	// return false;
	var smartphone_flag=<?php echo $smartphone_flag; ?>;
	// alert('---smartphone_flag---'+smartphone_flag);
	 //return false;
	if(surID != "" || surID != 0)
	{
		var Comp=<?php echo $Enroll_details->Company_id; ?>;
		var Enroll_id=<?php echo $Enroll_details->Enrollement_id; ?>;
		var Card_id='<?php echo $Enroll_details->Card_id; ?>';
		var Survey_id=surID;
		url='<?php echo base_url()?>index.php/Cust_home/getsurveyquestion?Survey_id='+surID+'&Company_id='+Comp+'&Enroll_id='+Enroll_id+'&Card_id='+Card_id+'&smartphone_flag='+smartphone_flag;	
		/* if(smartphone_flag==2)
		{
			window.open(url, '_blank','width=700, height=500');
		}
		else
		{ */
			window.location=url;
		// }
	}
	
}
</script>