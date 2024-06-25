<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
	<title>Survey Template 1</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_css/style.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_css/style2.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_css/style3.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_css/responsive.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_css/radio-checkbox.css">
</head>
<body>
<div class="container">
<?php
	$From_survey_mail = 1;	
	$Survey_data = json_decode( base64_decode($Survey_data) );
	$Survey_data = get_object_vars($Survey_data);
	$survey_id = $Survey_data['Survey_id'];
	$gv_log_compid = $Survey_data['Company_id'];
	$Enrollment_id = $Survey_data['Enroll_id'];	
	$Card_id = $Survey_data['Card_id'];
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
	if($Survey_response_count==0)
	{		
	?>
		<div class="navigation">
			<ol>
				<?php		
						if($Survey_details)
						{								
							foreach($Survey_details as $surdtls)
							{
								$Question_id=$surdtls['Question_id'];										
								?>
								<li><a href="#"  data-ref="<?php echo $Question_id ?>"><?php echo $Question_id ?></a></li>							
								<?php
							}
						} 
					?>
			</ol>
		</div>
			
		<form id="sign-form" class="sign-form" action="<?php echo base_url(); ?>index.php/Api/getsurveyquestionapi" method="POST" onSubmit="return checkForm(this)">
			
			<ol class="questions">
				
				<?php 
		
			$i=1;
			foreach($Survey_details as $surdtls)
			{
				
				if($i==1)
				{
					$class="class='active'";
				}
				else
				{
					$class="class=''";
				}
				
				$Question_id=$surdtls['Question_id'];
				$Multiple_selection=$surdtls['Multiple_selection'];	
				
				if($surdtls['Response_type'] == 2 )  //For Text Box Input Type
				{ 
				?>
					<li>
						<span><label for="<?php echo $Question_id ?>"><?php echo $i.'. '. $surdtls['Question']; ?></label></span>
						<textarea id="<?php echo $Question_id ?>" name="<?php echo $Question_id ?>" <?php echo $class; ?> ></textarea>
					</li>
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
						?>
						<li>
							<span><label for="<?php echo $Question_id ?>"><?php echo $i.'. '. $surdtls['Question']; ?></label></span>
							<div class="middle" style=" width:75%;margin-left:50px">											
								<?php
								foreach($choice_values as $ch_val) 
								{
									$Option_image=$ch_val['Option_image'];     //For Images	
									if($Option_image=='SurveyImages/survey.png')  
									{
										
									?>			
										
										<div class="styled-input-single">
											<input type="radio" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" <?php echo $class; ?> id="radio-example-<?php echo $Question_id.'_'.$ch_val['Value_id']; ?>"/>
											<label for="radio-example-<?php echo $Question_id.'_'.$ch_val['Value_id']; ?>"> 
												<?php echo $ch_val['Option_values']; ?>
											</label>
										</div>
											
									<?php 
									}  
									else
									{
									?>
										<label>
											<input type="radio" name="<?php echo $Question_id; ?>" value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" <?php echo $class; ?> />
											<div class="front-end box" style="margin: 5px;">
												<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>" class="rad_img" />
												<?php echo $ch_val['Option_values']; ?>	
											</div>
										</label>
											
									<?php									
									}								
								}
								?>
							</div>
						</li>
						<?php
						
					}
					else //For Multiselection i.e. Checkbox Buttons
					{
						?>
						<li>
							<span><label for="<?php echo $Question_id ?>"><?php echo $i.'. '. $surdtls['Question']; ?></label></span>
							<div class="middle" style=" width:75%;margin-left:50px">
							<?php
							foreach($choice_values as $ch_val) 
							{
								$Option_image=$ch_val['Option_image'];     //For Images	
								if($Option_image=='SurveyImages/survey.png')  
								{
								?>
										
									<div class="styled-input-single styled-input--square">
										<input type="checkbox" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>"  id="checkbox-example-<?php echo $ch_val['Value_id']?>" autocomplete="off" <?php echo $class; ?> />
										<label for="checkbox-example-<?php echo $ch_val['Value_id']?>" >
											<?php echo $ch_val['Option_values']; ?>
										</label>
									</div>
												
											
								<?php	
								}
								else
								{
								?>
									<label>
											<input type="checkbox" name="<?php echo $Question_id; ?>[]"  value="<?php echo $ch_val['Value_id'].'_'.$ch_val['Choice_id'] ?>" autocomplete="off" <?php echo $class; ?> />
											<div class="front-end box" style="margin: 5px;">
												<img src="<?php echo $this->config->item('base_url2')?><?php echo $ch_val['Option_image']; ?>"  class="rad_img">
												<?php echo $ch_val['Option_values']; ?>
											</div>
									</label>
								<?php	
								}								
							}
							?>
							</div>
						</li>
						<?php						
					}					
				}					
			$i++;
			} 
			?>	
				<li id="Submitbtn">					
				<input type="hidden" name="Survey_id" value="<?php echo App_string_encrypt($survey_id); ?>" />
				<input type="hidden" name="smartphone_flag" value="<?php echo App_string_encrypt($smartphone_flag); ?>" />
				<input type="hidden" name="From_survey_mail" value="<?php echo App_string_encrypt($From_survey_mail); ?>" />
				<input type="hidden" name="Company_id" value="<?php echo $gv_log_compid; ?>" />
				<input type="hidden" name="Enroll_id" value="<?php echo $Enrollment_id; ?>" />
				<input type="hidden" name="Card_id" value="<?php echo $Card_id; ?>" />			
				<p style="font-size: 27pt;text-align:center;">
					<input type="submit" name="submit" id="btnSubmit" value="Submit Survey" style="color:white;text-decoration:none;border: 5px solid #817FB4;padding: 7px;color: #817FB4;cursor: pointer;box-shadow: 2px 2px 2px 6px;"/>
				</p>
				</li>         
			</ol>			
			<div class="error-message"></div>			
		</form>			
		<h1 id="wf" style="opacity:0;width: 100%; margin-top:1.1em;display:none; margin-bottom:1em">Thank you</h1>	
		</div>
	
		<div class="container fixed-container">
			<div class="sign-form fixed-footer">
				<div id="prev-page" alt="Kiwi standing on oval"></div>
				<div id="next-page" alt="Kiwi standing on oval"></div>
			</div>
		</div>	
				
		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
		<script src="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_js/index.js"></script>
		<script src="<?php echo $this->config->item('base_url2'); ?>assets/portal_assets/survey_js/index2.js"></script>
	</div>    
	<?php 		
	}	
	else
	{ ?>
		<div id="messageBox" class="hidden">
			<div class="messageBoxContent">
				<span class="close" id="closeMessageBox">&times;</span>
				<p>It seems you have given the survey or you do not have any survey.</p>
			</div>
		</div> <?php
	}
	?>	
<?php //echo form_close(); ?>
</body>
</html>
<script language ="JavaScript" type="text/javascript">
function checkForm(oForm)
{
	document.getElementById("btnSubmit").disabled = true;	
	document.getElementById("btnSubmit").value="Survey Sending...";
}

const messageBox = document.getElementById("messageBox");
const closeMessageBoxButton = document.getElementById("closeMessageBox");

closeMessageBoxButton.addEventListener("click", () => {
    messageBox.style.display = "none";
});
</script>
<style>
.messageBoxContent {
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    width: 300px;
    position: fixed;
    top: 14%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}
</style>