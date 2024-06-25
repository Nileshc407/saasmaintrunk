<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Create New Password : iGainSpark</title>
	
	<!----------------------Safari form validation----------------------------------------------->
	<script src="<?php  echo $this->config->item('base_url2')?>assets/js/js-webshim/minified/polyfiller.js"></script>
    <script> 
        webshim.activeLang('en');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>
 <!--------------------------------------------------------------------------------------->	
	<link rel="shortcut icon" href="<?php echo $this->config->item('base_url2')?>images/logo_igain.ico" type="image/x-icon">
    <link href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>dist/css/AdminLTE.min.css" rel="stylesheet" />
	<link href="<?php echo base_url()?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css">	
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/bootstrap.js"></script>
	
	<?php echo form_open_multipart('Cust_home/first_time_login', array( 'id' => 'loginForm', 'name' => 'loginForm')); ?>

	<section class="content">
	<div class="container">
		
		<div class="col-md-12 col-xs-12 ">
			<div class="panel panel-info col-md-12 col-xs-12 ">
				<div class="panel-heading">
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-th"></span>
						Create New Password   
					</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-md-3" align="center"> 
						   <span class="glyphicon glyphicon-user img-thumbnail" style="font-size:115px;margin-top: 27px;"></span>
						</div>
						
						<div style="margin-top:22px;" class="col-xs-12 col-md-6">						
							<div class="form-group">
								<label for="inputName" class="control-label" id="password">New Password</label>
								<div class="input-group">
								  <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
								  <input class="form-control" type="password" id="New_Password" name="New_Password" placeholder="New Password" required><input type="checkbox" id="showHide" class="form-control" /><label class="control-label" for="showHide" id="showHideLabel">Show Password</label>
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputName" class="control-label" id="repassword" >Confirm New Password</label>
								<div class="input-group">
								  <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
								  <input class="form-control" type="password" id="Confirm_New_Password" name="Confirm_New_Password" placeholder="Confirm New Password" required>
								</div>
							</div>
							<!--<div class="form-group" id="password_match" style="display:none">							
								<div class="alert alert-danger alert-dismissible">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>New Password and Confirm New Password should not match ! </strong>
								</div>							
							</div>-->
							<br>
							<div class="col-xs-12 col-md-12" align="center">
								<button class="btn icon-btn-save btn-success " id="Save" type="submit">
								<span class="btn-save-label"><i class="glyphicon glyphicon-floppy-disk"></i></span> Save </button>
								<input type="hidden" name="Login_data" value="<?php echo $Login_data; ?>" />
							</div >
							
						</div>
						<div class="col-xs-12  col-md-3" style="margin-top:22px;"> 
							
								<label for="inputName" class="control-label"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span> Password Policy</label>
									<ul class="list-group" >
									  <li class="list-group-item" style="padding:0px 0px 0px 3px;"><span class="glyphicon glyphicon-remove" 
									   id="6_characters" ></span>  Password is minimum 6 characters</li>
									  <li class="list-group-item"  style="padding:0px 0px 0px 3px;"><span class="glyphicon glyphicon-remove"  
									   id="One_Capital" ></span>  One Upper Case Letter</li>
									  <li class="list-group-item"  style="padding:0px 0px 0px 3px;"><span class="glyphicon glyphicon-remove" 
									   id="One_Lower" ></span>  One Lower Case Letter</li>
									  <li class="list-group-item"  style="padding:0px 0px 0px 3px;"><span class="glyphicon glyphicon-remove"
									   id="Special_Character" ></span>  Special Character </li>
									  <li class="list-group-item"  style="padding:0px 0px 0px 3px;"><span class="glyphicon glyphicon-remove" 
									   id="One_Number" ></span>  One Number </li>
									</ul>
								
						</div>
						
							<!--<div class="col-xs-12 col-sm-12 col-md-12" > 
									<div class="col-xs-12 col-sm-12 col-md-3" > 
										<span class="glyphicon glyphicon-remove" id="6_characters" ></span>  Password is minimum 6 characters
									</div>
									<div class="col-xs-12 col-sm-12 col-md-2" > 
										<span class="glyphicon glyphicon-remove" id="One_Capital" ></span>  One Upper Case Letter
									</div>
									<div class="col-xs-12 col-sm-12 col-md-2" > 
										<span class="glyphicon glyphicon-remove" id="One_Lower" ></span>  One Lower Case Letter
									</div>
									<div class="col-xs-12 col-sm-12 col-md-2" > 
											<span class="glyphicon glyphicon-remove"  id="Special_Character" ></span>  Special Character
									</div>
									<div class="col-xs-12 col-sm-12 col-md-3" > 
										<span class="glyphicon glyphicon-remove"  id="One_Number" ></span>  One Number
								
									</div>
							</div>-->
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-xs-12  col-md-5"><strong>Copyright &copy; 2015-2020 <a href="http://www.miraclecartes.com" target="_blank">Miracle Smart Card Pvt. Ltd</a>.</strong> All rights reserved.</div>
						<div class="col-md-2">
						</div>
						<div class="col-xs-12  col-md-5"><strong style="float:right">Powered By <a target="_blank" href="<?php echo $partner_Company_Website; ?>" title="<?php echo $partner_Company_name; ?>"><?php echo $partner_Company_name; ?></a></strong></div>
					</div>
				</div>
			</div>
		</div>
		
		
	</div>
</section>		
		
<?php echo form_close(); ?>

<style type="text/css">
#showHide {
  width: 15px;
  height: 15px;
  float: left;
}
#showHideLabel {
  float: left;
  padding-left: 5px;
}
input[type=checkbox]
{
  -webkit-appearance:checkbox;
}
</style>

<script>

$(document).ready(function() {
  $("#showHide").click(function() {
    if ($("#New_Password").attr("type") == "password") {
      $("#New_Password").attr("type", "text");

    } else {
      $("#New_Password").attr("type", "password");
    }
  });
});

Validate_array = new Array();

$("#Save").click(function()
{
	var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	// var special = new RegExp("/^[a-zA-Z0-9- ]*$/");
	var new_password=$("#New_Password").val();
	var Confirm_Password=$("#Confirm_New_Password").val();
	var Error_count=0;
	
		if(new_password.length >= 6 )
		{			
			$("#6_characters").removeClass("glyphicon glyphicon-remove");
			$("#6_characters").addClass("glyphicon glyphicon-ok");	
			// Element was found, remove it.
			
		}
		else
		{			
			$("#6_characters").removeClass("glyphicon glyphicon-ok");
			$("#6_characters").addClass("glyphicon glyphicon-remove");
			// return false;
			Error_count++;
		}
		if(num.test(new_password) == true )
		{
			$("#One_Number").removeClass("glyphicon glyphicon-remove");
			$("#One_Number").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{										
			$("#One_Number").removeClass("glyphicon glyphicon-ok");
			$("#One_Number").addClass("glyphicon glyphicon-remove");		
			// return false;	

				Error_count++;
		}
		if(ucase.test(new_password) == true )
		{
			$("#One_Capital").removeClass("glyphicon glyphicon-remove");
			$("#One_Capital").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{
			$("#One_Capital").removeClass("glyphicon glyphicon-ok");
			$("#One_Capital").addClass("glyphicon glyphicon-remove");
			// return false;	
				Error_count++;
		}		
		if (/^[a-zA-Z0-9- ]*$/.test(new_password) == false) 
		{
			$("#Special_Character").removeClass("glyphicon glyphicon-remove");
			$("#Special_Character").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{
			$("#Special_Character").removeClass("glyphicon glyphicon-ok");
			$("#Special_Character").addClass("glyphicon glyphicon-remove");		
			// return false;
			Error_count++;
		}
		if(lcase.test(new_password) == true  )
		{
			$("#One_Lower").removeClass("glyphicon glyphicon-remove");
			$("#One_Lower").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{
			$("#One_Lower").removeClass("glyphicon glyphicon-ok");
			$("#One_Lower").addClass("glyphicon glyphicon-remove");			
			// return false;
				Error_count++;
		}		
	if(Error_count == 0)
	{
		var n = Confirm_Password.localeCompare(new_password);
		if( n == 0 )
		{
			$('#show_loader').modal('show');
			return true;
			//document.getElementById("password_match").style.display="";
		}
		else
		{
			// document.getElementById("password_match").style.display="";
			$('#password_match').modal('show');
			return false;
		}
		return true;
	}
	else
	{
		return false;
	}
	
	
});
 
</script>	
<style>

.glyphicon-ok{
	color: green;
}
.glyphicon-remove
{
	color: red;
}
</style>

<div id="show_loader" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"  >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Please Wait...</h4>
			</div>
			
			<div class="modal-body center-block">
				<div class="progress">
				  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
				</div>
			</div>				
		</div>
	</div>
</div>
	
	<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header" style="background-color:#428bca;color:#fff">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Application Information</h4>
		  </div>
		  <div class="modal-body">
			<p>Old Password and New Password should not be same.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	</div>
	</div>
	
	<div id="password_match" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header" style="background-color:#428bca;color:#fff">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Application Information</h4>
		  </div>
		  <div class="modal-body">
			<p>New Password and Confirm New Password did not match !</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	</div>
	</div> 
	<?php
	if(@$this->session->flashdata('invalid_error_code'))
	{
	?>
		<script>
			$('#myModal').modal('show');  //ravip@miraclecartes.com
		</script>
		
		
	<?php
	}
	?>
	
<style>
@media only screen and (min-width: 320px) {
	.list-group-item{
		font-size: 10px;
	}
}

@media only screen and (min-width: 375px) {
   .list-group-item{
		font-size: 10px;
	}
}
@media only screen and (min-width: 425px) {
  .list-group-item{
		font-size: 14px;
	}
}
@media only screen and (min-width: 768px) {
  .list-group-item{
		font-size: 14px;
	}
}
@media only screen and (min-width: 1024px) {
   .list-group-item{
		font-size: 14px;
	}
}
@media only screen and (min-width: 1440px) {
  .list-group-item{
		font-size: 14px;
	}
}

@media only screen and (min-width: 368px){
	.list-group-item{
		font-size: 14px;
	}
}

</style>