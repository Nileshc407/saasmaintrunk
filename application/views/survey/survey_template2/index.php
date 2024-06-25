<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
	<title>Survey Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet prefetch" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/portal_assets/survey_css/template2_style.css">	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Libre Franklin" rel="stylesheet">
	
	
	<style>
	    #k1{overflow-y: scroll;
		}
		
		#redbut{
			background:red;
		}
	</style>
</head>

<body>

	<div id="fullpage" class="wrapper" style="padding-left: 0;padding-right: 0;">
	
	<!--1st section-->
		
		
		<section class="vertical-scrolling" id="questionid_1">			
			<p id="t1">Welcome to Survey ....</p>
             <img src="<?php echo base_url(); ?>SurveyImages/default.gif" class="img-circle" style="height:200px; width:200px;">
			<p id="t1" style="margin-top:13px;">It takes your 5-6 minutes</p>
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#secondSection" style="">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--1st section ended-->
	
	<!--2nd section-->
		<!-- <section class="vertical-scrolling" id="questionid_2" id="k1">			

					<p id="t1">Q1.Enter below Fields?</p>
					<input class="textbox" type="text" placeholder="First name"> 
					<br><br> 
					<input class="textbox" type="text" placeholder="Middle name"> 
					<br><br> 
					<input class="textbox" type="text" placeholder="Last name"> 
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#secondSection">
					<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
				</a>
			</div>
		</section> -->
		
		<section class="vertical-scrolling" id="questionid_4">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#firstSection">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p id="t1">Q1.Enter below Fields?</p>
						<input class="textbox" type="text" placeholder="First name" id="t2"> 
						<br><br> 
						<input class="textbox" type="text" placeholder="Middle name" id="t2"> 
						<br><br> 
						<input class="textbox" type="text" placeholder="Last name" id="t2"> 
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#thirdSection">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
		
	<!--2nd section ended-->
	  
	<!--3rd section-->
		<section class="vertical-scrolling" id="questionid_3">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#secondSection" >
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row" >
					<div class="col-md-6 col-md-offset-3" >
						
						<p id="t1">Q2.Rate app?</p>
						<div class="star-rating">
							<input id="star-5" type="radio" name="rating" value="star-5" class="z1_radio">
							<label for="star-5" title="5 star" class="z1">
								<span>&#9733</span>
							</label>
										
							<input id="star-4" type="radio" name="rating" value="star-4" class="z1_radio">
							<label for="star-4" title="4 star"  class="z1">
								<span>&#9733</span>
							</label>
										
							<input id="star-3" type="radio" name="rating" value="star-3" class="z1_radio">
							<label for="star-3" title="3 star"  class="z1">
								<span>&#9733</span>
							</label>
							
							<input id="star-2" type="radio" name="rating" value="star-2" class="z1_radio">
							<label for="star-2" title="2 star"  class="z1">
								<span>&#9733</span>
							</label>
										
							<input id="star-1" type="radio" name="rating" value="star-1" class="z1_radio">
							<label for="star-1" title="1 star"  class="z1">
								<span>&#9733</span>
							</label>
						</div>
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#fourthSection">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--3rd section ended-->
	
	<!--4th section-->
		<section class="vertical-scrolling" id="questionid_4">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#thirdSection">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p id="t1">Q3.Select multiple images?</p>
						<input type="checkbox" id="myCheckbox1" />
							<label for="myCheckbox1">
							  <img src="<?php echo base_url(); ?>SurveyImages/default.png">
							</label>
							<input type="checkbox" id="myCheckbox2" />
							<label for="myCheckbox2">
							  <img src="<?php echo base_url(); ?>SurveyImages/default.png">
							</label>
							<input type="checkbox" id="myCheckbox3" />
							<label for="myCheckbox3">
							  <img src="<?php echo base_url(); ?>SurveyImages/default_1.png">
							</label>
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#fifthSection">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--4th section ended-->
		
	
		
	<!--5th section ended-->
		<section class="vertical-scrolling" id="questionid_5">		
			<div class="scroll-icon2 previous">
				<a href="#fourthSection">
					<img src="<?php echo base_url(); ?>SurveyImages/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
					<p id="t1">Q4.Select single option at time?</p>
					
						<div class="row">
							<!-- <div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<a href="#" class="thumbnail">
											<img src="https://images.typeform.com/images/pULc4L8XzJCT/choice/default#.png">
										</a>
									</div>
									<div class="panel-footer">
										<div class="radio" style="text-align: center;">
											<label>
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option4">
											</label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<a href="#" class="thumbnail">
											<img src="https://images.typeform.com/images/96YeRkX49wwy/choice/default#.png">
										</a>
									</div>
									<div class="panel-footer">
										<div class="radio" style="text-align: center;">
											<label>
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option4">
											</label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<a href="#" class="thumbnail">
											<img src="https://images.typeform.com/images/XkxKJABejTmq/choice/default#.png">
										</a>
									</div>
									<div class="panel-footer">
										<div class="radio" style="text-align: center;">
											<label>
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option4">
											</label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body">
										<a href="#" class="thumbnail">
											<img src="https://images.typeform.com/images/g6xrBV394Snm/choice/default#.png">
										</a>
									</div>
									<div class="panel-footer">
										<div class="radio" style="text-align: center;">
											<label>
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option4">
											</label>
										</div>
									</div>
								</div>
							</div> -->
						</div>
						
						 <div class="cc-selector">
							<input id="visa" type="radio" name="credit-card" value="visa" />
								<label for="visa">
									<img src="<?php echo base_url(); ?>SurveyImages/default.png">
								</label>
							
							<input id="mastercard" type="radio" name="credit-card" value="mastercard" />
								<label for="mastercard">
									<img src="<?php echo base_url(); ?>SurveyImages/default_2.png">
								</label>
						</div>
						
						
						
						
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#">
					<button class="button" style="vertical-align:middle"><span>Submit </span></button>
				</a>
			</div>
		</section>
	<!--5th section ended-->
	</div>
	
	<footer >
		<div class="progress" style="height: 40px; background:#c1b38a; width: 539px;" >
		  <div class="circle done">
			<span class="label">1</span>
			<span class="title">Personal</span>
		  </div>
		  <span class="bar done"></span>
		  <div class="circle done">
			<span class="label">2</span>
			<span class="title">Address</span>
		  </div>
		  <span class="bar half"></span>
		  <div class="circle active">
			<span class="label">3</span>
			<span class="title">Payment</span>
		  </div>
		  <span class="bar"></span>
		  <div class="circle">
			<span class="label">4</span>
			<span class="title">Review</span>
		  </div>
		  <span class="bar"></span>
		  <div class="circle">
			<span class="label">5</span>
			<span class="title">Finish</span>
		  </div>
		</div>
	</footer>
	
	<!--progress bar script-->
		<script>
			var i = 1;
			$('.progress .circle').removeClass().addClass('circle');
			$('.progress .bar').removeClass().addClass('bar');
			setInterval(function() {
			  $('.progress .circle:nth-of-type(' + i + ')').addClass('active');
			  
			  $('.progress .circle:nth-of-type(' + (i-1) + ')').removeClass('active').addClass('done');
			  
			  $('.progress .circle:nth-of-type(' + (i-1) + ') .label').html('&#10003;');
			  
			  $('.progress .bar:nth-of-type(' + (i-1) + ')').addClass('active');
			  
			  $('.progress .bar:nth-of-type(' + (i-2) + ')').removeClass('active').addClass('done');
			  
			  i++;
			  
			  if (i==0) {
				$('.progress .bar').removeClass().addClass('bar');
				$('.progress div.circle').removeClass().addClass('circle');
				i = 1;
			  }
			}, 1000);
		</script>
	<!--progress bar script ended-->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.min.js'></script>
	<script src="<?php echo base_url();?>assets/portal_assets/survey_js/index.js"></script>

</body>
</html>
