<!DOCTYPE html>
<html>
<head>
    <title>Survey Template-3</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Include SmartWizard CSS -->
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/survey_css/smart_wizard.css" rel="stylesheet" type="text/css" />
    
    <!-- Optional SmartWizard theme 
    <link href="../dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />-->
	
	<style>
		.searchable-container{margin:20px 0 0 0}
		.searchable-container label.btn-default.active{background-color:#007ba7;color:#FFF}
		.searchable-container label.btn-default{width:90%;border:1px solid #efefef;margin:5px; box-shadow:5px 8px 8px 0 #ccc;}
		.searchable-container label .bizcontent{width:100%;}
		.searchable-container .btn-group{width:90%}
		.searchable-container .btn span.glyphicon{
			opacity: 0;
		}
		.searchable-container .btn.active span.glyphicon {
			opacity: 1;
		}

		progress#p1::-webkit-progress-value { 
		background: #357ebd !Important; 
		color:#fff !IMPORTANT;
	}	
	</style>
	<script>
	
	window.onload = function ()
	{ 
		// alert("It's loaded!");
		$('#smartwizard').smartWizard("reset");
    //dom not only ready, but everything is loaded
	}
	
	
	/* $(function() {
    $('#search').on('keyup', function() {
        var pattern = $(this).val();
        $('.searchable-container .items').hide();
        $('.searchable-container .items').filter(function() {
            return $(this).text().match(new RegExp(pattern, 'i'));
        }).show();
    });
	}); */
	</script>
</head>
<body>

	<?php 
		// var_dump($Survey_details);
	echo form_open_multipart('Cust_home/getsurveyquestion','novalidate');
			
	?>
    <div class="container">
        
       
		<?php		
			// var_dump($Survey_data);
			//$Survey_data = json_decode( base64_decode($_REQUEST['Survey_data']) );			
			$Survey_data = json_decode( base64_decode($Survey_data) );
			$Survey_data = get_object_vars($Survey_data);
			$survey_id = $Survey_data['Survey_id'];
			$gv_log_compid = $Survey_data['Company_id'];
			$Enrollment_id = $Survey_data['Enroll_id'];	
			$Card_id = $Survey_data['Card_id'];
			// var_dump($Survey_data);
			if($Survey_data['Card_id']== "" || $Survey_data['Card_id']== '0')
			{			
			?>
				<!-- Modal -->	
				<script>
					alert('You have not been assigned Membership ID yet ...Please visit nearest outlet');
					window.close();
				</script>				
			<?php 
			} 
		?>
       
	<?php 
	if($Survey_response_count==0)
	{		
	?>
        <!-- SmartWizard html -->
		<div align="center" style="padding: 10px;" >
			<progress  role="progressbar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" value="0" max="100" id="p1" class="form-control" style="height: 33px;padding:0">0%</progress>&nbsp;<b class="text-center" id="percent" ></b>
		</div>
        <div id="smartwizard">
			
            <ul>
			
					<li>
						<a href="#00001">
							<small>
								<?php echo $Question_id ?>
							</small>
						</a>
					</li>
					<?php	
							// var_dump($Survey_data);
							
							$total_quetion=count($Survey_details);
							if($Survey_details)
							{								
								foreach($Survey_details as $surdtls)
								{
									$Question_id=$surdtls['Question_id'];	
									
									?>
										
										<li>
											<a href="#<?php echo $Question_id ?>">
												<small>
													<?php echo $Question_id ?>
												</small>
											</a>
										</li>
									<?php
								}
							}
							?>	
								
                <!--<li><a href="#step-1">Question 1<br /><small>This is Question description</small></a></li>
                <li><a href="#step-2">Question 2<br /><small>This is Question description</small></a></li>
                <li><a href="#step-3">Question 3<br /><small>This is Question description</small></a></li>
                <li><a href="#step-4">Question 4<br /><small>This is Question description</small></a></li>
                <li><a href="#step-5">Question 5<br /><small>This is Question description</small></a></li>-->
            </ul>
            
            <div>
			
				<div id="00001" class="" >
						<div>
						<h4>Your Membership Id</h4>
							<div class="form-group ">								
								<input type="text" disabled class="form-control" value="<?php echo $Card_id; ?>" ></textarea>								
							</div>
						</div>
				</div>
				<?php 
				// $i_array=array();
				$i=1;
				foreach($Survey_details as $surdtls)
				{
					$Question_id=$surdtls['Question_id'];
					$Multiple_selection=$surdtls['Multiple_selection'];	
					
					if($surdtls['Response_type'] == 2 )  //For Text Box Input Type
					{ 
					?>
					<div id="<?php echo $Question_id; ?>" class="" >
						<div>
						<h4><?php echo $i.'. '. $surdtls['Question']; ?></h4>
							<div class="form-group ">
								
								<textarea class="form-control" rows="3" name="<?php echo $Question_id; ?>"  id="textbox_<?php echo $Question_id; ?>" onchange="increase_bar(<?php echo $Question_id; ?>);" ></textarea>								
							</div>
						</div>
					</div>
					
					<?php
					}
					else if($surdtls['Response_type']==1 )  //For MCQ Values
					{
						$Choice_id=$surdtls['Choice_id'];
						$ci_object = &get_instance();
						$ci_object->load->model('Survey_model');								
						$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
						// echo"---Multiple_selection----".$Multiple_selection."----<br>---";
						if($Multiple_selection=='0') //For Single Selection i.e. Radio button
						{
							// echo"---Multiple_selection----".$Multiple_selection."----<br>---";
							?>
							<div id="<?php echo $Question_id; ?>" class="" >
								<h4><?php echo $i.'. '. $surdtls['Question']; ?></h4>
								<div >
								
							<?php
							foreach($choice_values as $ch_val) 
							{
								$Option_image=$ch_val['Option_image'];     //For Images
								
								
								
								if($Option_image=='SurveyImages/survey.png')  
								{				
									// echo"---WIthout Image----".$Option_image."----<br>---";
								?>	
									<div class="col-sm-6">
									<label for="accessible_<?php echo $ch_val['Value_id']; ?>" >
										<input type="radio"  id="accessible_<?php echo $ch_val['Value_id']; ?>" onClick="increase_bar(<?php echo $Question_id; ?>	);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>">
										<span><?php echo $ch_val['Option_values']; ?></span>										
									</label>
									</div>
								<?php
								}
								else
								{
									// echo"---With Image----".$Option_image."----<br>---";
								?>								
																		  
								<label for="accessible_<?php echo $ch_val['Value_id']; ?>" class="col-lg-6 col-xs-6">
									<input type="radio" id="accessible_<?php echo $ch_val['Value_id']; ?>" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>">
									<span> 
										<?php echo $ch_val['Option_values']; ?>	
									</span> 
									<span> 
																		
										<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" width="100px" > 
									</span>										
								</label>
								
												<!--<label for="pretty" class="spanClass">
													<input type="radio" value="pretty" name="quality" id="pretty"> 
													<span >accessible || pretty 
														<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px">
													</span>										
												</label>
												<label for="accessible-and-pretty" class="spanClass">
													<input type="radio" value="pretty"  name="quality" id="accessible-and-pretty" checked> 
													<span >accessible and pretty
														<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px">
													</span>										
												</label>-->	
								<?php									
								}
							}
							?>
							
							</div>
							</div>
							<?php
						
						} 
						else  //For Multiselection i.e. Checkbox Buttons
						{
							// echo"---Multiple_selection---->".$Multiple_selection."----<br>---";
							
							
							?>
								<div id="<?php echo $Question_id; ?>" class="" class="container">
								<h4><?php echo $i.'. '. $surdtls['Question']; ?></h4>
								<div>
							<?php 
							foreach($choice_values as $ch_val) 
							{
								$Option_image=$ch_val['Option_image'];     //For Images								
								if($Option_image=='SurveyImages/survey.png')  
								{
									// echo"---Without Image---Check box----".$Option_image."----<br>---";
									// echo"---Option_values----".$ch_val['Option_values']."----<br>---";
								?>
																
										<div class="[ form-group ]" >												
											<input type="checkbox" id="Check_<?php echo $ch_val['Value_id']?>"  onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" autocomplete="off" />
											<div class="[ btn-group ] col-sm-6">
												<label for="Check_<?php echo $ch_val['Value_id']?>" class="[ btn btn-primary ]" >
													<span class="[ glyphicon glyphicon-ok ]"></span>
													<span> </span>
												</label>
												<label for="Check_<?php echo $ch_val['Value_id']?>" class="[ btn btn-default active ]" style="min-width: 200px;">
													<?php echo $ch_val['Option_values']; ?>
												</label>
											</div>
										</div>
									
									
											
											
																		
								<?php
								}
								else
								{
									// echo"---With Image----".$Option_image."----<br>---";
								?>
										
									<label class="col-lg-6 col-md-6 col-xs-6">
										<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" class="img-thumbnail img-check" width="150px" height="150px" style="margin-left:20px;">
										<input type="checkbox" id="Check_<?php echo $ch_val['Value_id']?>" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" class="hidden" autocomplete="off">
										<p style="margin-left:20px;"><?php echo $ch_val['Option_values']; ?></p>
									</label>
								<?php									
								}
							}
							?>
								</div>
								</div>
							<?php
						}
					}
					$i++;
				}
				?>
					
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
			
			
			
			
               <!-- <div id="step-1" class="" >
                    <h2>Step 1 Content</h2>
                    <div>
						<div class="form-group ">
							<label for="exampleInputEmail1"><span class="required_info">Q. 1</span> Text Based Question</label>
							<textarea class="form-control" rows="3" name="description"  id="description" ></textarea>							
						</div>
					</div>
                </div>
                <div id="step-2" class="">
                    <h2>Step 2 Check Box</h2>
                    <div>
						<div class="[ form-group ]">
							<input type="checkbox" name="fancy-checkbox-primary" id="fancy-checkbox-primary" autocomplete="off" />
							<div class="[ btn-group ] ">
								<label for="fancy-checkbox-primary" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-primary" class="[ btn btn-default active ]">
									Good Value for Money
								</label>
							</div>							
							<input type="checkbox" name="fancy-checkbox-success" id="fancy-checkbox-success" autocomplete="off" />
							<div class="[ btn-group ] ">
								<label for="fancy-checkbox-success" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success1" id="fancy-checkbox-success1" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success1" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success1" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success2" id="fancy-checkbox-success2" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success2" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success2" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success3" id="fancy-checkbox-success3" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success3" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success3" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success4" id="fancy-checkbox-success4" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success4" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success4" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success5" id="fancy-checkbox-success5" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success5" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success5" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success6" id="fancy-checkbox-success6" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success6" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success6" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
							<input type="checkbox" name="fancy-checkbox-success8" id="fancy-checkbox-success8" autocomplete="off" />
							<div class="[ btn-group ]">
								<label for="fancy-checkbox-success8" class="[ btn btn-primary ]">
									<span class="[ glyphicon glyphicon-ok ]"></span>
									<span> </span>
								</label>
								<label for="fancy-checkbox-success8" class="[ btn btn-default active ]">
									Success Checkbox
								</label>
							</div>								
						</div>
					</div>
                </div>
                <div id="step-3" class="" >
					<h2>Step 3 Content</h2>
					<div>
						<h4>Radio Buttons</h4>
						<fieldset>
							<label for="1" class="spanClass">
								<input type="radio" value="pretty"  name="quality" id="1" checked>
								<span >accessible OR pretty</span>
							</label>
							<label for="2" class="spanClass">
								<input type="radio" value="pretty"  name="quality" id="2" checked>
								<span >accessible OR pretty</span>
							</label>
							<label for="3" class="spanClass">
								<input type="radio" value="pretty"  name="quality" id="3" checked>
								<span >accessible OR pretty</span>
							</label>
							<label for="4" class="spanClass">
								<input type="radio" value="pretty"  name="quality" id="4" checked>
								<span >accessible OR pretty</span>
							</label>
						</fieldset>
					</div>
				</div>
                <div id="step-4" class="" >
                    <h2>Step 4 Check Box Image</h2>
						<div>
							<div class="row">
								<form method="get">
									<div class="form-group container">	
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage">
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Running.png" alt="..." class="img-thumbnail img-check">
												<input type="checkbox" name="chk1" id="item4" value="val1" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Basketball.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk2" id="item4" value="val2" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Football.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk3" id="item4" value="val3" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
											
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible && pretty</p>
											</label>											
										</div>
									</div>
								</form>
							</div>
						</div>
				</div>
				<div id="step-5" class="">
                    <h2>Step 5 Image Radio Box</h2>
                    <div>
						<fieldset>									  
							<label for="accessible" class="spanClass">
								<input type="radio" value="accessible" name="quality" id="accessible">
								<span >accessible && pretty										
								<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px"> 
								</span>										
							</label>
							<label for="pretty" class="spanClass">
								<input type="radio" value="pretty" name="quality" id="pretty"> 
								<span >accessible || pretty 
									<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px">
								</span>										
							</label>
							<label for="accessible-and-pretty" class="spanClass">
								<input type="radio" value="pretty"  name="quality" id="accessible-and-pretty" checked> 
								<span >accessible and pretty
									<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px">
								</span>										
							</label>
							<label for="accessible-and-pretty1" class="spanClass">
								<input type="radio" value="pretty"  name="quality" id="accessible-and-pretty1" checked>
								<span >accessible OR pretty</span>
							</label>
						</fieldset>
					</div>
                </div>
				-->
				
					
            </div>
			
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
					alert('It seems you have given the survey or you do not have any survey.');
					window.close();
				</script>
			<?php 
		}
		else
		{
			?>
				<script>
					alert('It seems you have given the survey or you do not have any survey');
					url='<?php echo base_url()?>index.php/Cust_home/getsurvey';				
					window.location=url;					
				</script>				
			<?php
		} 
	}
	?>
	
	<?php echo form_close(); ?>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/survey_js/jquery.smartWizard.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            
            // Step show event 
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               //alert("You are on step "+stepNumber+" now");
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'final'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
               }
            });
            
            // Toolbar extra buttons
            var btnFinish = $('<button id="submit" ></button>').text('Submit')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ 
												return true;
												//alert('Submit Clicked'); 
											 } );
											 
           var btnCancel = $('<button id="Cancel" ></button>').text('<<')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); }); 
											 
        

			
            
            // Smart Wizard
            $('#smartwizard').smartWizard({ 
                    selected: 0, 
                    theme: 'default',
                    transitionEffect:'fade',
                    showStepURLhash: true,
                    toolbarSettings: {toolbarPosition: 'both',
                                      toolbarExtraButtons: [btnFinish, btnCancel]
                                    }
            });
                                         
            
            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });
            
            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });
            
            $("#next-btn").on("click", function() {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });

			
            
            /* $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });
            
            // Set selected theme on page refresh
            $("#theme_selector").change(); */
        });   
    </script>  
</body>
</html>
<style>
.sw-btn-prev
{
	margin-left: -50px !important;
}

.sw-theme-default .sw-toolbar-top
{
   display:none !important;
}

<!-- .sw-container tab-content{
min-height:250px !important;
} -->

.form-group input[type="checkbox"] {
    display: none;
}

.form-group input[type="checkbox"] + .btn-group > label span {
    width: 20px;
}

.form-group input[type="checkbox"] + .btn-group > label span:first-child {
    display: none;
}
.form-group input[type="checkbox"] + .btn-group > label span:last-child {
    display: inline-block;   
}

.form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
    display: inline-block;
}
.form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
    display: none;   
}
</style>
<style>

.funkyradio label {
    /*min-width: 400px;*/
   
    border-radius: 3px;
    border: 1px solid #D1D3D4;
    font-weight: normal;
	min-width: 60%;
    float: left;
    margin: 2px;
	
}
.funkyradio input[type="radio"]:empty, .funkyradio input[type="checkbox"]:empty {
    display: none;
}
.funkyradio input[type="radio"]:empty ~ label, .funkyradio input[type="checkbox"]:empty ~ label {
    position: relative;
    line-height: 2.5em;
    text-indent: 3.25em;
    
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.funkyradio input[type="radio"]:empty ~ label:before, .funkyradio input[type="checkbox"]:empty ~ label:before {
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    content:'';
    width: 2.5em;
    background: #D1D3D4;
    border-radius: 3px 0 0 3px;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before, .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #C2C2C2;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label, .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
    color: #888;
}
.funkyradio input[type="radio"]:checked ~ label:before, .funkyradio input[type="checkbox"]:checked ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
}
.funkyradio input[type="radio"]:checked ~ label, .funkyradio input[type="checkbox"]:checked ~ label {
    color: #777;
}
.funkyradio input[type="radio"]:focus ~ label:before, .funkyradio input[type="checkbox"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
}

.funkyradio-primary input[type="radio"]:checked ~ label:before, .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #337ab7;
}

</style>
<style>
.check
{
    opacity:0.2;	 
	
	
}
</style>
<script>
	$(document).ready(function(e){
    		$(".img-check").click(function(){
				$(this).toggleClass("check");
			});
	});
</script>

<style>


/* HTML5 Boilerplate accessible hidden styles */
[type="radio"] {
  border: 0; 
  clip: rect(0 0 0 0); 
  height: 1px; margin: -1px; 
  overflow: hidden; 
  padding: 0; 
  position: absolute; 
  width: 1px;
}

/* One radio button per line */
label {
  display: block;
  cursor: pointer;
  line-height: 2.5;
 /*  font-size: 1.5em; */
 font-size: 0.9em;
}

[type="radio"] + span {
  display: block;
}

/* the basic, unchecked style */
[type="radio"] + span:before {
  content: '';
  display: inline-block;
  width: 1em;
  height: 1em;
  vertical-align: -0.25em;
  border-radius: 1em;
  border: 0.125em solid #fff;
  box-shadow: 0 0 0 0.15em #000;
  margin-right: 0.75em;
  transition: 0.5s ease all;
}

/* the checked style using the :checked pseudo class */
[type="radio"]:checked + span:before {
  background: green;
  box-shadow: 0 0 0 0.25em #000;
}

/* never forget focus styling */
[type="radio"]:focus + span:after {
  
  font-size: 1.5em;
  line-height: 1;
  vertical-align: -0.125em;
}

legend {
  color: #fff;
  background: #000;
  padding: 0.25em 1em;
  border-radius: 1em;
}




</style>
<style>

.nav-tabs
{
	    display: none;
}
.btn-group
{
	margin: 14px 0 0 0px;
	min-width: 40%;
}
.btn btn-primary
{
	min-width: 77%;
}
#CheckImage
{
	padding:2px;
	margin-top: 4px;
}
[type="radio"]:checked + span:before
{
	background: #337ab7;
}

</style>

<script language="JavaScript">
		var myArray = [];
		function increase_bar(Q_id) 
		{
			// alert(Q_id);
			if (myArray.indexOf(Q_id) === -1)
			{
				myArray.push(Q_id);		
				var v1=document.getElementById('p1').value;
				document.getElementById("p1").value= v1 + Math.round(100/<?php echo count($Survey_details);?>);
				var final_per= v1 + Math.round(100/<?php echo count($Survey_details);?>);
				// alert(final_per);
				if(final_per > 100)
				{
					document.getElementById("percent").innerHTML =100  +'% Completed';
				}
				else
				{
					document.getElementById("percent").innerHTML =final_per  +'% Completed';
				}
				
			}
			else 
			{		
				
			}
			console.log(myArray); 
		}

	</script>