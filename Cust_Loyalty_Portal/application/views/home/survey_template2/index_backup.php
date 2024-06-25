<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
	<title>Survey Template 2</title>
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
		height: 5px;
	}
	progress#p1::-webkit-progress-value { 
		background: #357ebd !Important; 
	}
	</style>
</head>

<body>

	<div id="fullpage" class="wrapper" style="padding-left: 0;padding-right: 0;">
	
	<!--1st section-->
		
		
		<section class="vertical-scrolling" id="questionid_1">			
			<p id="t1">Welcome to Survey ....</p>
             <img src="https://images.typeform.com/images/QpE8ndzUL4/image/default#.gif" class="img-circle" style="height:200px; width:200px;">
			<p id="t1" style="margin-top:13px;">It takes your 5-6 minutes</p>
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#secondSection" style="">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
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
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p id="t1">Q1.Enter below Fields?</p>
						<input class="textbox" type="text" placeholder="First name" id="t2"> 
						
					</div>
				</div>
			</h3>
			
			<div class="scroll-icon">
				<p>Next</p>
				<a href="#thirdSection">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
		
	<!--2nd section ended-->
	  
	<!--3rd section-->
		<section class="vertical-scrolling" id="questionid_3">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#secondSection" >
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
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
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--3rd section ended-->
	
	<!--4th section-->
		<section class="vertical-scrolling" id="questionid_4">
			<div class="scroll-icon2 previous">
				<p>Previous</p>
				<a href="#thirdSection">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p id="t1">Q3.Select multiple images?</p>
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
				<a href="#fifthSection">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-down-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
		</section>
	<!--4th section ended-->
		
	
		
	<!--5th section ended-->
		<section class="vertical-scrolling" id="questionid_5">		
			<div class="scroll-icon2 previous">
				<a href="#fourthSection">
					<img src="http://animations.fg-a.com/arrows/yellow-arrow-up-1.gif" class="img-circle" style="height:20px; width:20px;">
				</a>
			</div>
			
			
			<h3>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
					<p id="t1">Q4.Select single option at time?</p>		
						
						
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
	<!--5th section ended-->
	</div>
	
	<footer >
		<div class="progress" style="height: 40px; background:#c1b38a; width: 539px;" >
		
			<progress  role="progressbar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" value="0" max="100" id="p1">0%</progress>
				<ul class="list-inline pull-left">
					<li> 
						<b class="text-center" id="percent" ></b>
					</li>
				</ul>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.min.js"></script>
	<!--<script src="js/index.js"></script>-->
	<script>
	
	
// variables
var $header_top = $('.header-top');
var $nav = $('nav');
var sectionsColor_array = ['#B8AE9C', '#222222', '#F2AE72', '#5C832F'];
var color_count = sectionsColor_array.length;
// fullpage customization
$('#fullpage').fullpage(
{
	// sectionsColor: ['#B8AE9C', '#348899', '#F2AE72', '#5C832F', '#B8B89F'],
	sectionsColor: ['#faf2db', '#faf2db', '#faf2db', '#faf2db', '#faf2db'],
	sectionSelector: '.vertical-scrolling',
	slideSelector: '.horizontal-scrolling',
	navigation: true,
	slidesNavigation: true,
	controlArrows: false,
	anchors: ['firstSection', 'secondSection', 'thirdSection', 'fourthSection', 'fifthSection'],
	menu: '#menu',
	afterLoad: function(anchorLink, index) 
	{
		$header_top.css('background', 'rgba(0, 47, 77, .3)');
		$nav.css('background', 'rgba(0, 47, 77, .25)');
	}
});

/* function invertColor(hex) 
{
    if (hex.indexOf('#') === 0) 
	{
        hex = hex.slice(1);
    }
	
    // convert 3-digit hex to 6-digits.
    if (hex.length === 3) 
	{
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
	
    if (hex.length !== 6) 
	{
        throw new Error('Invalid HEX color.');
    }
    // invert color components
    var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    // pad each with zeros and return
    return "#" + padZero(r) + padZero(g) + padZero(b);
}

function padZero(str, len) 
{
    len = len || 2;
    var zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}

function getRandomColor() 
{
    var color = Math.round(Math.random() * 0x1000000).toString(16);
    return "#" + padZero(color, 6);
} */

var i, box, color, bgColor;
var j = 0;
// var color_count = sectionsColor_array.length;
var color_count = 5;
for (i = 0; i < color_count; i++) 
{
	/* j++;
	color = getRandomColor();
	bgColor = invertColor(color);
	
	$("#questionid_" + j).css("background-color",bgColor);
	// $("#questionid_" + j + " h2").css("color",color);
	$("#questionid_" + j).css("color",color);
	
	$("#fp-nav ul li a span, .fp-slidesNav ul li a span").css("background",color);
	$("#fp-nav ul li a, .fp-slidesNav ul li a").css("color",color); */
	
	/* $("input[type=radio]:checked ~ .check").css("color",color);
	$("input[type=radio]:checked ~ .check::before").css("color",color);
	$("input[type=radio]:checked ~ label").css("color",color); */
}
   
$("#fullpage").bind("mousewheel", function() 
{
    return false;
});
	</script>
</body>
</html>
