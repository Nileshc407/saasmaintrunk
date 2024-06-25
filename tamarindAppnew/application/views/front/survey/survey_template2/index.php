<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
	<title>Survey Template 2 WIP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.css'>
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/survey_css/template2_style.css">	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Libre Franklin" rel="stylesheet">
	
	
	<style>
	    #k1{overflow-y: scroll;
		}
		
		#redbut{
			background:red;
		}
		progress#p1 {
		background: #ccc none repeat scroll 0 0;
		border: medium none;
		height: 10px;
		width: 100%;
		margin: -5px;
	}
	progress#p1::-webkit-progress-value { 
		background: #357ebd !Important; 
	}
	</style>
</head>

<body>

	<?php 
		// var_dump($Survey_details);
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
			// echo"----From_survey_mail----".$From_survey_mail."<br>";
			
			// die;
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
	
					
		foreach($Survey_details as $surdtls)
		{
			$Count_question_id[]=$surdtls['Question_id'];
		}
		$total_question=count($Count_question_id);
		// die;
		
	if($Survey_response_count==0)
	{
	?>
			<div id="fullpage" class="wrapper" style="padding-left: 0;padding-right: 0;">			
			<?php 
				$i_array=array();
				$i=1;
				foreach($Survey_details as $surdtls)
				{
					$Question_id=$surdtls['Question_id'];
					$Multiple_selection=$surdtls['Multiple_selection'];	
					
					$i_array[]=$i;					
					if($i==1)   //For First Active Tab
					{
						// echo"---first--i--Value here--".$i."---<br><br>";
						// die;
						?>
							<section class="vertical-scrolling" id="<?php echo $i; ?>">				
								<h3>
									<div class="row">
										<div class="col-md-12">											
											<p id="t1">Q<?php echo $i.'. '. $surdtls['Question']; ?></p><br>											
											<?php if($surdtls['Response_type'] == 2 )  //For Text Box Input Type
											{ 
											?>												
												<textarea name="<?php echo $Question_id; ?>" rows="4" cols="50" style="width:500px; height: 75px;" class="textbox t1" type="text" id="textbox_<?php echo $Question_id; ?>" onchange="increase_bar(<?php echo $Question_id; ?>);"  id="t2"> </textarea>
											<?php 
											}
											else if($surdtls['Response_type']==1 )  //For MCQ Values
											{
												$Choice_id=$surdtls['Choice_id'];
												$ci_object = &get_instance();
												$ci_object->load->model('Survey_model');								
												$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);
												
												if($Multiple_selection=='0') //For Single Selection i.e. Radio button
												{
													foreach($choice_values as $ch_val) 
													{
														$Option_image=$ch_val['Option_image'];     //For Images
														if($Option_image=='SurveyImages/survey.png')
														{														
														?>
															<div class="cc-selector">
																
																<input id="visa_<?php echo $ch_val['Value_id']; ?>" type="radio" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>"/>
																<label for="visa_<?php echo $ch_val['Value_id']; ?>">
																	<img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left" style="width: 30px;">
																	<div class="caption">
																	  <p><?php echo $ch_val['Option_values']; ?></p>
																	</div>
																</label>											
																
															</div>															
														<?php
														}
														else
														{ 
														?>
															<div class="cc-selector">
																
																<input id="visa_<?php echo $ch_val['Value_id']; ?>" type="radio" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>"/>
																<label for="visa_<?php echo $ch_val['Value_id']; ?>">
																	<img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left">
																	<div class="caption">
																	  <p><?php echo $ch_val['Option_values']; ?></p>
																	</div>
																</label>											
																
															</div>		
														<?php
														}
													}
												}
												else //For Multiselection i.e. Checkbox
												{
												
													foreach($choice_values as $ch_val) 
													{
														$Option_image=$ch_val['Option_image'];     //For Images
														if($Option_image=='SurveyImages/survey.png')
														{														
														?>
															<input type="checkbox" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
															<label for="myCheckbox1">
															  <img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left" style="width: 30px;">
															  <div class="caption">
																	  <p><?php echo $ch_val['Option_values']; ?></p>
																</div>
															</label>
															
																												
														<?php
														}
														else
														{ 
														?>
															<input type="checkbox" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
															<label for="myCheckbox1">
															  <img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left">
															  <div class="caption">
																	  <p><?php echo $ch_val['Option_values']; ?></p>
																</div>
															</label>
															
																														
														<?php
														}
													}												 
												}											
											}
											?>										
										</div>
									</div>
								</h3>			
								<div class="scroll-icon">									
									<p>Next</p>
									<a href="#<?php echo $i+1; ?>">
										<img src="<?php echo $this->config->item('base_url2')?>SurveyImages/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
									</a>									
								</div>
							</section>
					<?php
					}
					else
					{
						// echo"----i--Value here--".$i."---<br><br>";
						// die;
						?>		
						<section class="vertical-scrolling" id="<?php echo $i; ?>">		
							<div class="scroll-icon2 previous">
								<p>Previous</p>
								<a href="#<?php echo $i-1; ?>">
									<img src="<?php echo $this->config->item('base_url2')?>SurveyImages/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
								</a>								
							</div>	
							<h3>
								<div class="row">
									<div class="col-md-12">											
										<p id="t1">Q<?php echo $i.'. '. $surdtls['Question']; ?></p><br>									
										<?php if($surdtls['Response_type'] == 2 )  //For Text Box Input Type
										{ 
										?>												
											<textarea name="<?php echo $Question_id; ?>" rows="4" cols="50" style="width:500px; height: 75px;" class="textbox t1" type="text" id="textbox_<?php echo $Question_id; ?>" onchange="increase_bar(<?php echo $Question_id; ?>);"  id="t2"></textarea>
										<?php 
										}
										else if($surdtls['Response_type']==1 )  //For MCQ Values
										{
											// echo"----Response_type--".$surdtls['Response_type']."---<br><br>";
											$Choice_id=$surdtls['Choice_id'];
											$ci_object = &get_instance();
											$ci_object->load->model('Survey_model');								
											$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($Choice_id);					
											if($Multiple_selection=='0') //For Single Selection i.e. Radio button
											{
												// echo"----Multiple_selection--".$Multiple_selection."---<br><br>";
												foreach($choice_values as $ch_val) 
												{
													$Option_image=$ch_val['Option_image'];     //For Images
													if($Option_image=='SurveyImages/survey.png')
													{
														// echo"----Option_image--".$Option_image."---<br><br>";
													?>
														<!--<div class="cc-selector">-->
														<input id="visa_<?php echo $ch_val['Value_id']; ?>" type="radio" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>"/>
															<label for="visa_<?php echo $ch_val['Value_id']; ?>">
																<img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left" style="width: 30px;">
																<div class="caption">
																	<p><?php echo $ch_val['Option_values']; ?></p>
																</div>
															</label>
																														
															
														<!-- </div> -->	
													
													<?php
													}
													else
													{ 
														// echo"----Option_image--".$Option_image."---<br><br>";
													?>
														<!--<div class="cc-selector">-->
															
															<input id="visa_<?php echo $ch_val['Value_id']; ?>" type="radio" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>"/>
															<label for="visa_<?php echo $ch_val['Value_id']; ?>">
																<img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left">
																<div class="caption">
																	<p><?php echo $ch_val['Option_values']; ?></p>
																</div>
															</label>
															
														<!-- </div> -->	
													<?php
													}
												}
											}
											else //For Multiselection i.e. Checkbox
											{
												// echo"----Multiselection--".$Multiselection."---<br><br>";
											
												foreach($choice_values as $ch_val) 
												{
													$Option_image=$ch_val['Option_image'];     //For Images
													if($Option_image=='SurveyImages/survey.png')
													{														
													?>
														<input type="checkbox" id="Check_<?php echo $ch_val['Value_id']?>" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
														<label for="Check_<?php echo $ch_val['Value_id']?>">
														  <img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left" style="width: 30px;">
														 <div class="caption">
														  <p><?php echo $ch_val['Option_values']; ?></p>
														</div>
														</label>
																											
													<?php
													}
													else
													{ 
													?>
														<input type="checkbox" id="Check_<?php echo $ch_val['Value_id']?>" onClick="increase_bar(<?php echo $Question_id; ?>);" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" />
														<label for="Check_<?php echo $ch_val['Value_id']?>">
														  <img class="img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" align="left">
														 <div class="caption">
														  <p><?php echo $ch_val['Option_values']; ?></p>
														</div>
														</label>
																													
													<?php
													}
												}											 
											}											
										}
										?>										
									</div>
								</div>
							</h3>	
							<div class="scroll-icon">	
								<?php if($i != $total_question) { ?>
								<p>Next</p>
								<a href="#<?php echo $i+1; ?>">
									<img src="<?php echo $this->config->item('base_url2')?>SurveyImages/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
								</a>									
								<?php } else { ?>
								
								<a href="#">
									<button class="button" style="vertical-align:middle"><span>Submit </span></button>
								</a>
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
								<?php } ?>
							</div>
						</section>
					<?php
					}					
					$i++;
				
					
				}
				// die;
					?>
			</div>
	<?php 		
	
		$I_commaList = implode(',', $i_array);
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
	<footer >
		<div class="progress" style="height: 40px; background:#c1b38a; width: 100%;" >
		
			<progress  role="progressbar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" value="0" max="100" id="p1">0%</progress>&nbsp;<b class="text-center" id="percent" ></b>		
		</div>
	</footer>
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
				document.getElementById("percent").innerHTML = v1 + Math.round(100/<?php echo count($Survey_details);?>)  +'% Completed';
			}
			else 
			{		
				
			}
			console.log(myArray); 
		}

	</script>
	<!--progress bar script-->
		
	<!--progress bar script ended-->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.min.js"></script>
	<!--<script src="js/index.js"></script>-->
	<script>
	
	
		// variables
		var $header_top = $('.header-top');
		var $nav = $('nav');
		var sectionsColor_array =['#B8AE9C', '#222222'];
		var color_count = sectionsColor_array.length;
		// fullpage customization
		$('#fullpage').fullpage(
		{
			sectionsColor:['#faf2db','#faf2db','#faf2db','#faf2db','#faf2db','#faf2db','#faf2db','#faf2db','#faf2db','#faf2db'],
			sectionSelector: '.vertical-scrolling',
			slideSelector: '.horizontal-scrolling',
			navigation: true,
			slidesNavigation: true,
			controlArrows: false,			
			anchors: [<?php echo $I_commaList; ?>],
			menu: '#menu',
			afterLoad: function(anchorLink, index) 
			{	
				$header_top.css('background', 'rgba(0, 47, 77, .3)');
				$nav.css('background', 'rgba(0, 47, 77, .25)');
			}
		});
		var i, box, color, bgColor;
		var j = 0;		  
		$("#fullpage").bind("mousewheel", function() 
		{
			return false;
		});
	</script>
</body>
</html>
<style>
#fp-nav ul
{
	display:none;
}
span
	{
		font-size: 14px;
	}
h3{
	font-size:20px;
}
input[type=radio]:checked ~ label {
    color: #333333;
}
.caption{
   margin-top: 53px;
   font-size: smaller;
}
input[type=radio]
{
	display:none;
}
label
{
	font-weight:unset;
}
.textbox
{
	font-family: Helvetica,Arial;
    font-weight: unset;
}
</style>