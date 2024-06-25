<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Survey Template 1</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/survey_css/bootstrap.min.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	
    <style type="text/css">
	
	body{
		background-color:#e5f3f5;
		color: gray;
	}
	.wizard 
	{   
		background-color: #e5f3f5;
	}
    .wizard .nav-tabs {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }
    .wizard > div.wizard-inner {
        position: relative;
		margin-top: 23px;
    }
.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}
.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 50px;
    height: 50px;
    line-height: 50px;
    display: inline-block;
    border-radius: 100px;
    background: #fff;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab i{
    color:#555555;
}
.wizard li.active span.round-tab {
    background: #fff;
    border: 3px solid gray;
    
}
.wizard li.active span.round-tab i{
    color: #5bc0de;
}

span.round-tab:hover {
    color: #333;
    border: 2px solid #333;
}

.wizard .nav-tabs > li {
    width: 9%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: gray;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: gray;
}

.wizard .nav-tabs > li a {
    width: 50px;
    height: 50px;
    margin: 10px auto;
    border-radius: 100%;
    padding: 0;
}

.wizard .nav-tabs > li a:hover 
{
	background: transparent;
}

.wizard .tab-pane 
{
	position: relative;
    padding-top: 40px;
	min-height: 100px;
}
.wizard h3 
{
    margin-top: 0;
}
@media(max-width : 585px ) 
{

    .wizard {
        width: 90%;
        height: auto !important;
    }
    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }
    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }
    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
	.wizard .nav-tabs > li {
		width: 20%;
	}
	.form-group
	{
		padding: 26px;
	}
	.btn-group, .btn-group-vertical
	{		
		padding-top: 12px;
	}
	div.checkRadioContainer
	{
		width: 100% !important;
	}
}
.container {
  
    width: 80%;
	background-color: #e5f3f5;
}
.wizard h3
{
	border-bottom: 1px solid #3276b1;
    margin-top: 0;
    padding-bottom: 10px;
}
h3, .h3
{
	font-size: 20px;
}
ul 
{
  list-style-type: none;
}

li 
{
  display: inline-block;
}
input[type="checkbox"][id^="cb"] 
{
  display: none;
}
input[type="radio"][id^="cb"] 
{
  display: none;
}

label 
{
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
}
label:before 
{
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}
label img 
{
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}
:checked + label 
{
  border-color: #ddd;
}

:checked + label:before 
{
  content: "✓";
  background-color: gray;
  transform: scale(1);
}

:checked + label img 
{
  transform: scale(0.9);
  z-index: -1;
  border: 2px solid gray;
  padding: 5px;
}
.fa-check:before
{
	 color: gray;
	 margin-right: 26px;
}
.btn-primary
{
	
	background-color: gray;
    border-color: gray;
}
.btn-primary:hover
{
	background-color: #357ebd;
}

div.checkRadioContainer > label > input 
{
    visibility: hidden;
}

div.checkRadioContainer 
{
  
	width: 50%;
    display: block;
    margin: 0 auto;
    float: left;
}
div.checkRadioContainer > label 
{
    display: block;
    border: 1px solid gray;
    cursor: pointer;
	text-align: center;
}
div.checkRadioContainer > label > span 
{
    display: inline-block;
    vertical-align: top;
    line-height: 2em;
	font-weight: 100;
}
div.checkRadioContainer > label > input + i 
{
    visibility: hidden;
    color: #428bca;
    margin-left: -0.5em;
    margin-right: 0.2em;
}
div.checkRadioContainer > label > input:checked + i 
{
    visibility: visible;
}
.modal-backdrop.in
{
	opacity: 1.5;
    background-color: #e5f3f5;
}
.img-responsive
{
	margin: 0 auto;
}
.modal-content
{
	box-shadow:0 5px 100px rgba(0, 0, 0, .5);
}

/* progress#p1 
{
  height: 5px;
  background-color: #f3f3f3 !Important;
} */

progress#p1 {
    background: #ccc none repeat scroll 0 0;
    border: medium none;
    height: 5px;
}
progress#p1::-webkit-progress-value { 
    background: #357ebd !Important; 
}
.fa.fa-check.fa-2x
{
	float: left;
    margin-left: 2px;
}
</style>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>	





</head>
<body>
	<?php 	
	echo form_open_multipart('Cust_home/getsurveyquestion','novalidate');
	if(@$this->session->flashdata('survey_feed'))
	{		
	?>
		<!-- Modal -->	
		<script>					
		$(window).load(function(){
			$('#my_succuss').modal('show');
		}); 				
		function close_window_su()
		{ 
			window.close();
		}
		</script>
		<!-- Modal -->
		<div class="modal fade" id="my_succuss" role="dialog">
			<div class="modal-dialog">						
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" onclick="close_window_su();return false;" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Application Information</h4>
				</div>
				<div class="modal-body">
				  <p><?php echo $this->session->flashdata('survey_feed'); ?></p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" onclick="close_window_su();return false;" data-dismiss="modal">Close</button>
				</div>
			  </div>					  
			</div>
		</div>
		<!-- Modal -->	
		
	<?php
	}				 			
	?>
		<?php		
			// var_dump($Survey_data);
			//$Survey_data = json_decode( base64_decode($_REQUEST['Survey_data']) );			
			$Survey_data = json_decode( base64_decode($Survey_data) );
			$Survey_data = get_object_vars($Survey_data);
			$survey_id = $Survey_data['Survey_id'];
			$gv_log_compid = $Survey_data['Company_id'];
			$Enrollment_id = $Survey_data['Enroll_id'];	
			$Card_id = $Survey_data['Card_id'];
			
			// echo"----survey_id----".$survey_id."<br>";
			// die;
			
			if($Survey_data['Card_id']== "" || $Survey_data['Card_id']== '0')
			{			
			?>
				<!-- Modal -->	
				<script>					
				$(window).load(function(){
					$('#myModal').modal('show');
				}); 				
				function close_window1()
				{ 
					window.close();
				}
				</script>
				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">						
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" onclick="close_window1();return false;" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Application Information</h4>
						</div>
						<div class="modal-body">
						  <p>You have not been assigned Membership ID yet ...Please visit nearest outlet</p>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" onclick="close_window1();return false;" data-dismiss="modal">Close</button>
						</div>
					  </div>					  
					</div>
				</div>
				<!-- Modal -->	
			<?php 
			} 
			?>
			
	<?php 
	if($Survey_response_count==0)
	{
	?>
	<div class="container">
		<div class="row">
						
			<section>
			<div class="wizard">
				<div class="wizard-inner">
					<div class="connecting-line"></div>
					<ul class="nav nav-tabs" role="tablist">			
					
						<?php	
							// var_dump($Survey_data);
							
							$total_quetion=count($Survey_details);					
							
							$i=1;						
							if($Survey_details)
							{
								
								foreach($Survey_details as $surdtls)
								{
									$Question_id=$surdtls['Question_id'];	
									
									if($i==1)
									{
										?>				
										<li role="presentation" class="active">
											<a href="#<?php echo $Question_id ?>" data-toggle="tab" aria-controls="<?php echo $i ?>" role="tab" title="<?php echo $i ?>">
												<span class="round-tab">
													<?php echo"Q.".$i ?>
													<!--<img src="<?php //echo $this->config->item('base_url2')?>SurveyImages/question-sign.png">-->
												</span>
											</a>
										</li>
									<?php
									}
									else
									{
									?>	
										<li role="presentation" class="disabled">
											<a href="#<?php echo $Question_id ?>" data-toggle="tab" aria-controls="<?php echo $i ?>" role="tab" title="<?php echo $i ?>">
												<span class="round-tab">
													<?php echo"Q.".$i ?>
													<!--<img src="<?php //echo $this->config->item('base_url2')?>SurveyImages/question-sign.png">-->
												</span>
											</a>
										</li>
									<?php
									}
									$i++;
									
								}
							}
							?>	
							<li role="presentation" class="disabled" style="display:none">
								<a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
									<span class="round-tab">
										<i class="glyphicon glyphicon-ok"></i>
									</span>
								</a>
							</li>
					</ul>
				</div>

				
					<div class="tab-content" id="tab12">			
						<?php 
							$i=1;							
							if($Survey_details)
							{
								$i=1;
								foreach($Survey_details as $surdtls)
								{
									$Question_id=$surdtls['Question_id'];
									$Multiple_selection=$surdtls['Multiple_selection'];	
									// echo"---Multiple_selection--".$Multiple_selection."-----<br><br>";
									if($i==1)   //For First Active Tab
									{
										?>				
										<div class="tab-pane active" role="tabpanel" id="<?php echo $Question_id ?>">
											<h3><?php echo $i.'. '. $surdtls['Question']; ?></h3>										
											<div class="checkRadioContainer">
											
												<?php if($surdtls['Response_type'] == 2 )  //For Text Box Input Type
												{ 
													// echo"-----Text Based Question-----<br><br>";	
												?>											
													<div class="form-group">
														<textarea class="form-control" id="textbox_<?php echo $Question_id; ?>" onchange="increase_bar(<?php echo $Question_id; ?>);" rows="4" cols="50" name="<?php echo $Question_id; ?>" ></textarea>
													</div>
													<ul class="list-inline pull-right">				
														<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>														
													</ul>
												<?php 
												}
												else if($surdtls['Response_type']==1 )  //For MCQ Values
												{ 
													// echo"-----MCQ Based Question-----<br><br>";
											
													$Choice_id=$surdtls['Choice_id'];
													$ci_object = &get_instance();
													$ci_object->load->model('Survey_model');								
													$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
													//for Radio Button												
													if($Multiple_selection=='0') //For Single Selection i.e. Radio button
													{			
														// echo"-----MCQ Radio Based Question-----<br><br>";
														
															foreach($choice_values as $ch_val)
															{
																$Option_image=$ch_val['Option_image'];     //For Images
																if($Option_image=='images/no_image.jpeg' || $Option_image=='images/no_image.jpeg')
																{
																	?>														
																	<label>
																		<input type="radio" id="cb<?php echo $ch_val['Choice_id']; ?>" class="next-step" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
																		<i class="fa fa-check fa-2x"></i>
																		<span><?php echo $ch_val['Option_values']; ?></span>
																	</label>
																<?php 
																}
																else
																{ 
																	?>
																		<ul style="display: inline-block; margin: 0 auto;">
																			<li>
																				<input type="radio" onClick="increase_bar(<?php echo $Question_id; ?>);" class="next-step" id="cb<?php echo $ch_val['Value_id'] ?>" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" required/>
																				<label for="cb<?php echo $ch_val['Value_id'] ?>">
																					<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" />
																				</label>
																				<p class="text-center"><?php echo $ch_val['Option_values']; ?></p>
																			</li>
																		</ul>
																	<?php
																}
															
															}
															?>
																<ul class="list-inline pull-right">				
																	<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>
																</ul>
															<?php
													}
													else     //For Multiselection i.e. Checkbox
													{											
														//for Checkbox Button	
														// echo"-----MCQ Checkbox Based Question-----<br><br>";
														
															foreach($choice_values as $ch_val)
															{
																$Option_image=$ch_val['Option_image'];
																if($Option_image=='images/no_image.jpeg' || $Option_image=='images/no_image.jpeg')
																{
																	?>					
																	<label>
																		<input type="checkbox" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
																		<i class="fa fa-check fa-2x"></i>
																		<span><?php echo $ch_val['Option_values']; ?></span>
																	</label>
																<?php 
																}
																else
																{ 
																	?>
																		<ul style="display: inline-block; margin: 0 auto;">
																			<li>
																				<input type="checkbox"  onClick="increase_bar(<?php echo $Question_id; ?>);" id="cb<?php echo $ch_val['Value_id'] ?>" name="<?php echo $Question_id; ?>[]" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
																				<label for="cb<?php echo $ch_val['Value_id'] ?>">
																					<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" />
																				</label>
																				<p class="text-center"><?php echo $ch_val['Option_values']; ?></p>
																			</li>
																		</ul>
																	<?php
																}
																
															}
															?>
																<ul class="list-inline pull-right">				
																	<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>
																</ul>
															<?php
													}												
														
												}
												?>
											</div>                        
										</div>
										<?php
									}
									else
									{
										
										?>
										<div class="tab-pane" role="tabpanel" id="<?php echo $Question_id ?>">
											<h3><?php echo $i.'.     '. $surdtls['Question']; ?></h3>										
											<div class="checkRadioContainer">											
												<?php if($surdtls['Response_type'] == 2 ) 
												{ 
													// echo"-----Text Based Question-----<br><br>";
													?>											
													<div class="form-group">
														<textarea class="form-control" id="textbox_<?php echo $Question_id; ?>" onchange="increase_bar(<?php echo $Question_id; ?>);" rows="4" cols="50" name="<?php echo $Question_id; ?>"  ></textarea>
														<span id="texterror_<?php echo $Question_id; ?>" style="display:none"> Enter Something</span>
													</div>
													<ul class="list-inline pull-right">				
														<li><button type="button" class="btn btn-primary prev-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/left-arrow.png" style="width:20px"></button></li>
														
														<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>
														
													</ul>
													<?php 
												}
												else if($surdtls['Response_type']==1 ) 
												{
														 
													
													$Choice_id=$surdtls['Choice_id'];
													$ci_object = &get_instance();
													$ci_object->load->model('Survey_model');								
													$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
													//for Radio Button	
																											
																											
													if($Multiple_selection=='0')
													{		
																											
															foreach($choice_values as $ch_val)
															{
																
																$Option_image=$ch_val['Option_image'];
																if($Option_image=='images/no_image.jpeg' || $Option_image=='images/no_image.jpeg')
																{
																	
																	?>														
																	<label>
																		<input type="radio" onClick="increase_bar(<?php echo $Question_id; ?>);" class="next-step"  name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" required/>
																		<i class="fa fa-check fa-2x"></i>
																		<span><?php echo $ch_val['Option_values']; ?></span>
																	</label>
																<?php 
																}
																else
																{ 
																	//echo"-----MCQ Radio Based Question-----<br><br>";
																	?>
																		<ul style="display: inline-block; margin: 0 auto;">
																			<li>
																				<input type="radio" class="next-step" id="cb<?php echo $ch_val['Value_id'] ?>" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" required/>
																				<label for="cb<?php echo $ch_val['Value_id'] ?>">
																					<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" />
																				</label>
																				<p class="text-center"><?php echo $ch_val['Option_values']; ?></p>
																			</li>
																		</ul>	
																	<?php
																}
															
															}
															
															?>
																<ul class="list-inline pull-right">				
																	<li><button type="button" class="btn btn-primary prev-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/left-arrow.png" style="width:20px"></button></li>
																	
																	<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>
																</ul>
															<?php 
															
													}
													else
													{											
														//for Checkbox Button	
														
															foreach($choice_values as $ch_val)
															{
																// echo"-----MCQ Checkbox Based Question-----<br><br>";
																
																$Option_image=$ch_val['Option_image'];
																if($Option_image=='images/no_image.jpeg' || $Option_image=='images/no_image.jpeg')
																{
																	?>					
																	<label>
																		<input type="checkbox" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
																		<i class="fa fa-check fa-2x"></i>
																		<span><?php echo $ch_val['Option_values']; ?></span>
																	</label>
																<?php 
																}
																else
																{ 
																	?>
																	<ul style="display: inline-block; margin: 0 auto;">
																		<li>
																			<input type="checkbox"  onClick="increase_bar(<?php echo $Question_id; ?>);" id="cb<?php echo $ch_val['Value_id'] ?>" name="<?php echo $Question_id; ?>[]" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
																			<label for="cb<?php echo $ch_val['Value_id'] ?>">
																				<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" />
																			</label>
																			<p class="text-center"><?php echo $ch_val['Option_values']; ?></p>
																		</li>
																	</ul>
																<?php
																}
																
															}
															?>
																<ul class="list-inline pull-right">				
																	<li><button type="button" class="btn btn-primary prev-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/left-arrow.png" style="width:20px"></button></li>
																	
																	<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>
																</ul>
															<?php
													}	
														
												}
												?>											
											</div>
										</div>									
										<?php
									}
									$i++;
								}
							}
							?>		
						<div class="tab-pane" role="tabpanel" id="complete">
							<h3>You have successfully completed Survey</h3>
							
							<ul class="list-inline pull-left">
								<li>
									<button type="submit" name="submit" value="Submit" id="submit" class="btn btn-primary">Submit</button>
								</li>
								<?php 								
								$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id);
								$Survey_data1 = base64_encode(json_encode($myData1)); 					
								?>
								<input type="hidden" name="Survey_id" value="<?php echo $survey_id; ?>" />
								<input type="hidden" name="Company_id" value="<?php echo $gv_log_compid; ?>" />
								<input type="hidden" name="Enroll_id" value="<?php echo $Enrollment_id; ?>" />
								<input type="hidden" name="smartphone_flag" value="<?php echo $smartphone_flag; ?>" />
								<input type="hidden" name="From_survey_mail" value="<?php echo $From_survey_mail; ?>" />
								<input type="hidden" name="Survey_data" value="<?php echo $Survey_data1; ?>" />							
							</ul>
							<ul class="list-inline pull-right">				
								<li><button type="button" class="btn btn-primary prev-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/left-arrow.png" style="width:20px"></button></li>
							</ul>
						</div>
						<div class="clearfix"></div>
					</div>
				
			</div>
		</section>
	   </div>
		<div class="row">
			<div class="col-md-6">
				<progress  role="progressbar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" value="0" max="100" id="p1">0%</progress>
				<ul class="list-inline pull-left">
					<li> 
						<b class="text-center" id="percent" ></b>
					</li>
				</ul>			
			</div>
			<div class="col-md-3">	</div>
			<div class="col-md-3">		
				<!--<ul class="list-inline pull-right">
				
					<li><button type="button" class="btn btn-primary prev-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/left-arrow.png" style="width:20px"></button></li>
					
					<li><button type="button" class="btn btn-primary next-step"><img src="<?php echo $this->config->item('base_url2')?>SurveyImages/right-arrow.png" style="width:20px"></button></li>
					
				</ul>-->
			</div>			   
		   <br />
		   <br />		
		</div>
	</div>
	<?php 
	
	}	
	else
	{
		if($From_survey_mail==1)
		{
			?>	
			<script>		
					$(window).load(function(){
						$('#myModal_done').modal('show');
					});					
					function close_window_done() 
					{
						close();
						
					}
				</script>
					<!-- Modal -->
					<div class="modal fade" id="myModal_done" role="dialog">
						<div class="modal-dialog">						
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" onclick="close_window_done();return false;" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Application Information</h4>
							</div>
							<div class="modal-body">
							  <p>It seems you have given the survey or you do not have any survey.</p>
							</div>
							<div class="modal-footer">
							  <button type="button" onclick="close_window_done();return false;" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  
						</div>
					</div>
					<!-- Modal -->
			
	<?php 
		}
		else
		{
		?>
			<script>		
					$(window).load(function(){
						$('#myModal_done_app').modal('show');
					});					
					
						url='<?php echo base_url()?>index.php/Cust_home/getsurvey';
						$(window).load(function(){
							$('#myModal_done').modal('show');
						});					
						function close_window_app() 
						{
							window.location=url;					
						}
						
					
				</script>
					<!-- Modal -->
					<div class="modal fade" id="myModal_done_app" role="dialog">
						<div class="modal-dialog">						
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" onclick="close_window_app();return false;" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Application Information</h4>
							</div>
							<div class="modal-body">
							  <p>It seems you have given the survey or you do not have any survey.</p>
							</div>
							<div class="modal-footer">
							  <button type="button" onclick="close_window_app();return false;" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  
						</div>
					</div>
					<!-- Modal -->
		<?php
		} 
	}

?>		
<?php echo form_close(); ?>

<script type="text/javascript">

$('#submit').click(function () 
{
	
	/* <?php	
	foreach($Survey_details as $surdtls)
	{
		$Question_id=$surdtls['Question_id'];			
		$Multiple_selection=$surdtls['Multiple_selection'];
		$Choice_id=$surdtls['Choice_id'];			
		if($surdtls['Response_type'] == 2 )
		{
			?>
				$("textarea").each(function() 
				{
					if($(this).val() === "")
					{
						// alert('You not entered any text in text box questions!');
						
					}
					else
					{
						// alert('You entered text in text box questions!');
					}
				});
			<?php 
		}						
		$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);	
		if($Multiple_selection=='0') //For Single Selection i.e. Radio button
		{			
			?>
				var checked = $("#tab12 :radio:checked");
					var groups = [];
					$("#tab12 :radio").each(function() {
						if (groups.indexOf(this.name) < 0) 
						{
							groups.push(this.name);
						}
					});						
					if (groups.length == checked.length) 
					{
						// alert('all are checked!');
					}
					else 
					{
						// var total = groups.length - checked.length;
						// alert(total + ' group(s) are not selected');
						alert(' Please select Radio button Question ');
					}		
		<?php 				
		}
		else
		{
		?>			
			if ($("input[type=checkbox]:checked").length === 0) 
			{
				alert('Please select checkbox button Question!');
				return false;
			}
			else
			{
				alert('you select all  checkbox button Question!');
			}
		<?php 
		}  
	}	
	?> */
	
	// confirm("Press Response all Question before submitting Survey!");
	
	/* if(confirm("Are you sure! to submit Survey?")){
       
	   return true;
	   
	}
    else{
        return false;
    } */
	
});

$(document).ready(function () {
	
	//Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);
		

    });
});
function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
</script>





<script language="JavaScript">
var myArray = [];
function increase_bar(Q_id) 
{
	if (myArray.indexOf(Q_id) === -1) 
	{		

		myArray.push(Q_id);		
		var v1=document.getElementById('p1').value;
		document.getElementById("p1").value= v1 + Math.round(100/<?php echo count($Survey_details);?>);
		// document.getElementById("percent").value= v1 + Math.round(100/<?php echo count($Survey_details);?>) +'%';
		document.getElementById("percent").innerHTML = v1 + Math.round(100/<?php echo count($Survey_details);?>)  +'% Completed';
	}
	else 
	{		
		
	}
	console.log(myArray); 
}

</script>
<script>
</script>
</body>
</html>
