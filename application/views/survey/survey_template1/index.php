<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
	<title>Survey Template 1</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/portal_assets/survey_css/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/portal_assets/survey_css/style2.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/portal_assets/survey_css/style3.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/portal_assets/survey_css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/portal_assets/survey_css/radio-checkbox.css">
</head>
<body>
	<div class="container">
		<div class="navigation">
			<ol>
				<li><a href="#"  data-ref="Q1">1</a></li>
				<li><a href="#"  data-ref="Q2">2</a></li>
				<li><a href="#"  data-ref="Q3">3</a></li>
				<li><a href="#"  data-ref="Q4">4</a></li>
				<li><a href="#"  data-ref="Q5">5</a></li>
				<li><a href="#"  data-ref="Q6">6</a></li>
				<li><a href="#"  data-ref="Q8">7</a></li>
			</ol>
		</div>
		
		<form id="sign-form" class="sign-form" action="#" method="POST">
			
			<ol class="questions">
				
				<li>
					<span><label for="Q1">Are you satisfied by our Loyalty Program?</label></span>
					<div class="two-column">
						<div class="single-col">
							<div class="styled-input-container">
								<div class="styled-input-single">
									<input class="active" type="radio" name="Q1" value="1" id="radio-example-one" />
									<label for="radio-example-one">Yes</label>
								</div>
								<div class="styled-input-single">
									<input class="active" type="radio" name="Q1"  value="0" id="radio-example-two" />
									<label for="radio-example-two">No</label>
								</div>
							</div>
						</div>
					</div>
				</li>
				
				<li>
					<span><label for="Q2">Which Merchandizing Category do you like the most?</label></span>
					<div class="two-column">
						<div class="single-col">
							<div class="styled-input-container styled-input--square">
								<div class="styled-input-single">
									<input type="checkbox" name="Q2[]" id="checkbox-example-one"  value="1" />
									<label for="checkbox-example-one">Smartphones</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q2[]" id="checkbox-example-two"  value="2" />
									<label for="checkbox-example-two">Movie Tickets</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q2[]" id="checkbox-example-three"  value="3" />
									<label for="checkbox-example-three">Footwear</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q2[]" id="checkbox-example-four" value="4" />
									<label for="checkbox-example-four">Books</label>
								</div>
							</div>
						</div>
					</div>
				</li>
				
				<li>
					<span><label for="Q3">Which of the following words would you use to describe the program?</label></span>
					
					<div class="two-column">
						<div class="single-col">
							<div class="styled-input-container styled-input--square">
								<div class="styled-input-single">
									<input type="checkbox" name="Q3[]" id="checkbox-example-one1" value="1" />
									<label for="checkbox-example-one1">User Friendly</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q3[]" id="checkbox-example-two2" value="2" />
									<label for="checkbox-example-two2">Impractical</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q3[]" id="checkbox-example-three3" value="3" />
									<label for="checkbox-example-three3">High Quality</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q3[]" id="checkbox-example-four4" value="4" />
									<label for="checkbox-example-four4">Poor Quality</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q3[]" id="checkbox-example-five5" value="5" />
									<label for="checkbox-example-five5">Good Value for Money</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q3[]" id="checkbox-example-six6" value="6" />
									<label for="checkbox-example-six6">Overpriced</label>
								</div>
							</div>
						</div>
					</div>
				</li>
				
				<li>
					<span><label for="Q4">Would you like to purchase any of our products again?</label></span>
					
					<div class="two-column">
						<div class="single-col">
							<div class="styled-input-container styled-input--square">
								<div class="styled-input-single">
									<input type="checkbox" name="Q4[]" id="checkbox-example-one11" value="1" />
									<label for="checkbox-example-one11">Extremely likely</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q4[]" id="checkbox-example-two22" value="2" />
									<label for="checkbox-example-two22">Not so likely</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q4[]" id="checkbox-example-three33" value="3" />
									<label for="checkbox-example-three33">Very likely</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q4[]" id="checkbox-example-four44" value="4" />
									<label for="checkbox-example-four44">Not at all likely</label>
								</div>
								<div class="styled-input-single">
									<input type="checkbox" name="Q4[]" id="checkbox-example-five55" value="5" />
									<label for="checkbox-example-five55">Somewhat likely</label>
								</div>
							</div>
						</div>
					</div>
				</li>
				
				<li>
					<span><label for="Q5">Any comments/ suggestions for improvements</label></span>
					<textarea id="Q5" name="Q5"></textarea>
					<!-- <input id="Q5" name="Q5" type="text" autofocus/> -->
				</li>
				
				<li>
					<span><label for="Q6">Are you satisfied by our Loyalty Program?</label></span>
					<div class="middle">
						<label>
							<input type="checkbox" name="Q6[]" value="1" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/Desert.jpg" class="rad_img"/>
								Option 1
							</div>
						</label>
						<label>
							<input type="checkbox" name="Q6[]" value="2" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/Hydrangeas.jpg" class="rad_img" />
								Option 2
							</div>
						</label>						
						<label>
							<input type="checkbox" name="Q6[]" value="3" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/Jellyfish.jpg" class="rad_img"/>
								Option 3
							</div>
						</label>
						<label>
							<input type="checkbox" name="Q6[]" value="4" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/Koala.jpg" class="rad_img" />
								Option 4
							</div>
						</label>						
						<label>
							<input type="checkbox" name="Q6[]" value="5" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/Lighthouse.jpg" class="rad_img"/>
								Option 5
							</div>
						</label>

						<label>
							<input type="checkbox" name="Q6[]" value="6" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/Penguins.jpg" class="rad_img" />
								Option 6
							</div>
						</label>
					</div>
				</li>
				
				
				
				<li>
					<span><label for="Q8">Are you satisfied by our Loyalty Program?</label></span>
					<div class="middle">
						<label>
							<input type="radio" name="Q8[]" value="1" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/yes.png" class="rad_img"/>
								Yes
							</div>
						</label>

						<label>
							<input type="radio" name="Q8[]" value="2" />
							<div class="front-end box">
								<img src="<?php echo base_url();?>SurveyImages/no.png" class="rad_img" />
								No
							</div>
						</label>
					</div>
				</li>
				
				<li id="Submitbtn">
					<p style="font-size: 32pt;text-align:center;">
						<input type="submit" name="submit" value="Submit" style="color:white;text-decoration:none;border: 5px solid #817FB4;padding: 7px;color: #817FB4;"/>
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
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script src="<?php echo base_url();?>assets/portal_assets/survey_js/index.js"></script>
    <script src="<?php echo base_url();?>assets/portal_assets/survey_js/index2.js"></script>

</body>
</html>
