<!DOCTYPE html>
<html>
<head>
    <title>Survey Template 3</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Include SmartWizard CSS -->
    <link href="<?php echo base_url();?>assets/portal_assets/survey_css/smart_wizard.css" rel="stylesheet" type="text/css" />    
    <!-- Optional SmartWizard theme -->
    <link href="dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
	
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

		
		
		
		
			

			
	</style>
	<script>
	
	$(function() {
    $('#search').on('keyup', function() {
        var pattern = $(this).val();
        $('.searchable-container .items').hide();
        $('.searchable-container .items').filter(function() {
            return $(this).text().match(new RegExp(pattern, 'i'));
        }).show();
    });
	});
	
	
	
	
	
	
	</script>
</head>
<body>
    <div class="container">
        
       

       
        
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li><a href="#step-1">Question 1<br /><small>This is Question description</small></a></li>
                <li><a href="#step-2">Question 2<br /><small>This is Question description</small></a></li>
                <li><a href="#step-3">Question 3<br /><small>This is Question description</small></a></li>
                <li><a href="#step-4">Question 4<br /><small>This is Question description</small></a></li>
                <li><a href="#step-5">Question 5<br /><small>This is Question description</small></a></li>
            </ul>
            
            <div>
                <div id="step-1" class="" >
                    <h2>Question 1</h2>
                    <div>
						<div class="form-group ">
							<label for="exampleInputEmail1"><span class="required_info">Q. 1</span> Text Based Question</label>
							<textarea class="form-control" rows="3" name="description"  id="description" ></textarea>
							
						</div>
					</div>
                </div>
                <div id="step-2" class="">
                    <h2>Question 2 Check Box</h2>
                    <div>
							<div class="[ form-group ]">							
								<input type="checkbox" name="fancy-checkbox-primary" id="fancy-checkbox-primary" autocomplete="off" />
								<div class="[ btn-group ] ">
									<label for="fancy-checkbox-primary" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-primary" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
							
								<input type="checkbox" name="fancy-checkbox-success" id="fancy-checkbox-success" autocomplete="off" />
								<div class="[ btn-group ] ">
									<label for="fancy-checkbox-success" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success1" id="fancy-checkbox-success1" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success1" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success1" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success2" id="fancy-checkbox-success2" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success2" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success2" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success3" id="fancy-checkbox-success3" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success3" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success3" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success4" id="fancy-checkbox-success4" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success4" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success4" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success5" id="fancy-checkbox-success5" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success5" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success5" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success6" id="fancy-checkbox-success6" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success6" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success6" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								<input type="checkbox" name="fancy-checkbox-success8" id="fancy-checkbox-success8" autocomplete="off" />
								<div class="[ btn-group ]">
									<label for="fancy-checkbox-success8" class="[ btn btn-primary ]">
										<span class="[ glyphicon glyphicon-ok ]"></span>
										<span> </span>
									</label>
									<label for="fancy-checkbox-success8" class="[ btn btn-default active ]">
										Checkbox Option
									</label>
								</div>
								
								
							</div>
					</div>
                </div>
                <div id="step-3" class="" >
					<h2>Question 3 </h2>
					<div>
							<h4>Radio Buttons Options</h4>
								<fieldset>
									<label for="1" class="spanClass">
										<input type="radio" value="pretty"  name="quality" id="1" checked>
										<span >accessible </span>
									</label>
									<label for="2" class="spanClass">
										<input type="radio" value="pretty"  name="quality" id="2" checked>
										<span >pretty</span>
									</label>
									<label for="3" class="spanClass">
										<input type="radio" value="pretty"  name="quality" id="3" checked>
										<span >Both</span>
									</label>
									<label for="4" class="spanClass">
										<input type="radio" value="pretty"  name="quality" id="4" checked>
										<span >Not Both</span>
									</label>
								</fieldset>
								
					</div>
				</div>
                <div id="step-4" class="" >
                    <h2>Question 4 Check Box Image</h2>
                    <div>
							<div class="row">
								<form method="get">
									<div class="form-group container">	
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage">
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Running.png" alt="..." class="img-thumbnail img-check">
												<input type="checkbox" name="chk1" id="item4" value="val1" class="hidden" autocomplete="off">
												<p >accessible </p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Basketball.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk2" id="item4" value="val2" class="hidden" autocomplete="off">
												<p >pretty</p>
											</label>
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Football.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk3" id="item4" value="val3" class="hidden" autocomplete="off">
												<p >accessible OR pretty</p>
											</label>
											
										</div>
										<div class="col-md-3 col-xs-6">
											<label class="btn btn-primary" id="CheckImage" >
												<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="checkbox" name="chk4" id="item4" value="val4" class="hidden" autocomplete="off">
												<p >accessible And pretty</p>
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
										<span >accessible 
										
										<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px"> 
										</span>										
									  </label>

									  <label for="pretty" class="spanClass">
										<input type="radio" value="pretty" name="quality" id="pretty"> 
										<span >pretty 
											<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px">
										</span>
										
									  </label>

									  <label for="accessible-and-pretty" class="spanClass">
										<input type="radio" value="pretty"  name="quality" id="accessible-and-pretty" checked> 
										<span >accessible OR pretty
											<img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." width="100px">
										</span>
										
									  </label>
									  <label for="accessible-and-pretty1" class="spanClass">
										<input type="radio" value="pretty"  name="quality" id="accessible-and-pretty1" checked>
										<span >accessible AND pretty</span>
									  </label>
								</fieldset>
								
					</div>
                </div>
            </div>
        </div>
        
        
    </div>
    
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/portal_assets/survey_js/jquery.smartWizard.min.js"></script>

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
            var btnFinish = $('<button></button>').text('Submit')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ alert('Submit Clicked'); });
            var btnCancel = $('<button></button>').text('Reset')
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
    opacity:0.5;
	color:#996;
	
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
  font-size: 1.5em;
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
fieldset {
  font-size: 1em; 
  padding: 2em;
  border-radius: 0.5em;
}
legend {
  color: #fff;
  background: #000;
  padding: 0.25em 1em;
  border-radius: 1em;
}

.p {
  text-align: center;
  font-size: 14px;
  padding-top: 120px;
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
