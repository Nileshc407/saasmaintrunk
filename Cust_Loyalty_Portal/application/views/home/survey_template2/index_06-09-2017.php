<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
	<title>Survey Template 2 WIP</title>
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
		echo"---total----".count($Count_question_id)."---<br>";
		// die;
		
	if($Survey_response_count==0)
	{
	?>
	<div id="fullpage" class="wrapper" style="padding-left: 0;padding-right: 0;">
	
	<!--1st section-->		
		<section class="vertical-scrolling" id="1">			
			<p id="t1">Welcome to Survey ....</p>
             <img src="https://images.typeform.com/images/QpE8ndzUL4/image/default#.gif" class="img-circle" style="height:200px; width:200px;">
			<p id="t1" style="margin-top:13px;">It takes your 5-6 minutes</p>
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#2" style="">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--1st section ended-->
	
	
	<!--2nd section-->		
		<section class="vertical-scrolling" id="2">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#1">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p id="t1">Q2.Enter below Fields?</p>
						<input class="textbox" type="text" placeholder="First name" id="t2"> 
						
					</div>
				</div>
			</h3>			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#3">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
		
	<!--2nd section ended-->
	
	  
	<!--3rd section-->
		<section class="vertical-scrolling" id="3">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#2" >
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>			
			<h3>
				<div class="row" >
					<div class="col-md-6 col-md-offset-3" >
						
						<p id="t1">Q3.Rate app?</p>
						
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#4">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--3rd section ended-->	
	
	
	
	<!--4th section-->
		<section class="vertical-scrolling" id="4">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#3">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p id="t1">Q4.Select multiple images?</p>
						<input type="checkbox" id="myCheckbox1" />
							<label for="myCheckbox1">
							  <img src="https://images.typeform.com/images/g6xrBV394Snm/choice/default#.png">
							</label>
						<input type="checkbox" id="myCheckbox2" />
							<label for="myCheckbox2">
							  <img src="https://images.typeform.com/images/96YeRkX49wwy/choice/default#.png">
							</label>
						<input type="checkbox" id="myCheckbox3" />
							<label for="myCheckbox3">
							  <img src="https://images.typeform.com/images/pULc4L8XzJCT/choice/default#.png">
							</label>
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#5">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--4th section ended-->
		
	
		
	<!--5th section ended-->
		<section class="vertical-scrolling" id="5">		
			<div class="scroll-icon2 previous">
				<a href="#4">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>	
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
					<p id="t1">Q5.Select single option at time?</p>						
						<div class="cc-selector">
							<input id="visa" type="radio" onClick="increase_bar(1);" name="credit-card" value="visa" />
								<label for="visa">
									<img src="https://images.typeform.com/images/96YeRkX49wwy/choice/default#.png">
								</label>
							
							<input id="mastercard" type="radio" name="credit-card" value="mastercard" />
								<label for="mastercard">
									<img src="https://images.typeform.com/images/pULc4L8XzJCT/choice/default#.png">
								</label>
						</div>
					</div>
				</div>
			</h3>			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#6">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--5th section ended-->
	
	
	<!--6th section ended-->
		<section class="vertical-scrolling" id="6">		
			<div class="scroll-icon2 previous">
				<a href="#5">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>	
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
					<p id="t1">Q6.Select single option at time?</p>						
						<div class="cc-selector">
							<input id="visa" type="radio" onClick="increase_bar(1);" name="credit-card" value="visa" />
								<label for="visa">
									<img src="https://images.typeform.com/images/96YeRkX49wwy/choice/default#.png">
								</label>
							
							<input id="mastercard" type="radio" name="credit-card" value="mastercard" />
								<label for="mastercard">
									<img src="https://images.typeform.com/images/pULc4L8XzJCT/choice/default#.png">
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
	<!--6th section ended-->
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
	<footer >
		<div class="progress" style="height: 40px; background:#c1b38a; width: 100%;" >
		
			<progress  role="progressbar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" value="0" max="100" id="p1">0%</progress>&nbsp;<b class="text-center" id="percent" ></b>
				
		  <?php /* ?><div class="circle done">
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
		  </div><?php  */ ?>
		</div>
	</footer>
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
		var sectionsColor_array =['#B8AE9C', '#222222', '#F2AE72', '#5C832F'];
		var color_count = sectionsColor_array.length;
		// fullpage customization
		$('#fullpage').fullpage(
		{
			sectionsColor:['#faf2db', '#faf2db', '#faf2db', '#faf2db','#faf2db', '#faf2db'],
			sectionSelector: '.vertical-scrolling',
			slideSelector: '.horizontal-scrolling',
			navigation: true,
			slidesNavigation: true,
			controlArrows: false,
			anchors: ['1', '2', '3', '4', '5', '6'],
			menu: '#menu',
			afterLoad: function(anchorLink, index) 
			{	
				$header_top.css('background', 'rgba(0, 47, 77, .3)');
				$nav.css('background', 'rgba(0, 47, 77, .25)');
			}
		});

		var i, box, color, bgColor;
		var j = 0;
		// var color_count = sectionsColor_array.length;
		var color_count = 5;
		for (i = 0; i < color_count; i++) 
		{
			
		}
		   
		$("#fullpage").bind("mousewheel", function() 
		{
			return false;
		});
	</script>
</body>
</html>
