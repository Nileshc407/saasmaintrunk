<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
  
  
  
  
  
</head>
<body>


<div class="container text-center">
    <div class="row">
        <div class="col-xs-6" style=" margin-top: 25px;">
            
			<img src="http://localhost/CI_IGAINSPARK_LIVE_NEW/uploads/3.jpeg" class="img-circle" height="65" width="65" alt="Avatar">
			<p><a href="#">Welcome Back <?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name;?></a></p>
        </div>
        <div class="col-xs-6">
          <p>
				<button type="button" class="btn btn-default btn-sm" style=" margin-top: 25px;">
					<span class="glyphicon glyphicon-th-list"></span> View Menu 
				</button>
			</p>
        </div>		
    </div>
	
	<div class="row">
        <div class="col-xs-6">
            
				<button type="button" class="btn btn-outline-secondary">
					New & trending Items
				</button>
        </div>
        <div class="col-xs-6">
         
				<button type="button" class="btn btn-outline-secondary">
					Top offers for you
				</button>
      
        </div>		
    </div>
	
	<div class="row" style="background-color:#D6D9D6;">
	
		 
			
				
		
				<div class="col-xs-3" style="float:left">
         
					<p>Platinum Card</p>
					<button type="button" class="btn btn-outline-secondary">
						View Benefits
					</button>
      
				</div>	
				<div class="col-xs-3">
				 
						<svg viewBox="0 0 120 120">
						  <circle cx="55" cy="55" r="50" class="dashed" />
						  <foreignObject x="5" y="5" height="100px" width="100px">
							<text x="55" y="60">
								100
							  </text>
						  </foreignObject>
						</svg>
			  
				</div>
				
				<div class="col-xs-3" style="float:left">
         
					<p> Platinum Card Platinum Card Platinum Card Platinum Card Platinum Card </p>
					
      
				</div>
				<div class="col-xs-3">         
					<button type="button" class="btn btn-outline-secondary" style="margin-left:5px;">
						View Benefits
					</button>
					<button type="button" class="btn btn-outline-secondary" style="margin-left:66px;">
						View Benefits
					</button>
      
				</div>
        		
		
		
    </div>
	
	
	
			
	
</div>

</body>
</html>
<style>
svg{
  height: 100px;
  width: 100px;
  margin: 0px 0px 0px 40px;
  float:right !IMPORTANT;
}
circle {
  fill: transparent;
  stroke: green;
  stroke-width: 2;
}
.solid{
  stroke-dasharray: none;
}
.dashed {
  stroke-dasharray: 8, 8.5;
}
.dotted {
  stroke-dasharray: 0.1, 12.5;
  stroke-linecap: round;
}
text {
  width: 100px;
  text-anchor: middle;
  fill: green;
  font-weight: bold;
  text-align: center;
}

</style>