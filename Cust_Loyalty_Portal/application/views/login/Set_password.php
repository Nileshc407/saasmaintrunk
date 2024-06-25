<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Set New Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	<link href="<?php echo $this->config->item('base_url2')?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $this->config->item('base_url2')?>assets/css/slider.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>		
	<link href="<?php echo $this->config->item('base_url2')?>css/login.css" rel="stylesheet">
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/bootstrap.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/common.js"></script>
	<link href="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />	
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/alert_function.js"></script>	
</head>
<body style="">
<div class="container">
<?php if($Enroll_Pwd_set_code == $Pwd_set_code) { ?>
	<div class="row">
		<div class="col-xs-12 col-md-2"></div>
		<div class="col-xs-12 col-md-8"><br/>	
			<div class="modal-content">	
			  <div class="modal-header">
				<h4 class="modal-title" style="background-color:#332005;color:#fff;text-align:center">Set Password</h4>
			  </div>
				<div class="modal-body">
					<div class="form-group has-feedback" id="has-feedback21">
					  <label for="inputName" class="control-label">New Password</label>
					  <input type="password" class="form-control" name="new_Password" id="new_Password" placeholder="Enter new password" >
						<span class="glyphicon" id="glyphicon21" aria-hidden="true"></span>						
						<div class="help-block" id="help-block21" ></div>
						<input type="checkbox" id="showHide" class="form-control" /><label class="control-label" for="showHide" id="showHideLabel">Show Password</label>
					</div><br>
					<div class="form-group has-feedback" id="has-feedback20">
						<label for="inputName" class="control-label">Confirm Password</label>
						<input type="password" class="form-control" name="confirm_Password"   id="confirm_Password" placeholder="Enter confirm password" >
						<span class="glyphicon" id="glyphicon20" aria-hidden="true"></span>						
						<div class="help-block" id="help-block20" ></div>   
					</div>
					
					<div class="form-group">
						<label for="inputName" class="control-label"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span> Password Policy</label>
							<ul class="list-group" >
								<li class="list-group-item" style="padding:0px 0px 0px 3px">
									<span class="glyphicon glyphicon-remove" id="6_characters" ></span>  Password is minimum 8 characters
								</li>
								<li class="list-group-item"  style="padding:0px 0px 0px 3px">
									<span class="glyphicon glyphicon-remove" id="One_Capital" ></span>  One Upper Case Letter
								</li>
								<li class="list-group-item"  style="padding:0px 0px 0px 3px">
									<span class="glyphicon glyphicon-remove" id="One_Lower" ></span>  One Lower Case Letter
								</li>
								<li class="list-group-item"  style="padding:0px 0px 0px 3px">
									<span class="glyphicon glyphicon-remove" id="Special_Character" ></span>  Special Character 
								</li>
								<li class="list-group-item"  style="padding:0px 0px 0px 3px">
									<span class="glyphicon glyphicon-remove" id="One_Number" ></span>  One Number 
								</li>
							</ul>							
					</div>
					<div class="modal-footer">
						<div class="form-group has-feedback" id="has-feedback22">
							<span class="glyphicon" id="glyphicon22" aria-hidden="true"></span>						
							<div class="help-block" id="help-block22" ></div>   
						</div>
						<input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
						<button type="button" class="btn btn-default" name="change_pwd" id="change_pwd" >Submit</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-2"></div>		
	</div>	
<?php } else { ?>
	<div class="row">
		<div class="col-xs-12 col-md-2"></div>
		<div class="col-xs-12 col-md-8"><br/>	
			<div class="modal-content">	
			  <div class="modal-header">
				<h4 class="modal-title" style="background-color:#332005;color:#fff;text-align:center">Application Information</h4>
			  </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputName" class="control-label">
						The link that you are trying to view is already accessed. It can be viewed and used only once and is then destroyed.
						</label>							
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" name="close" id="close" onclick="window.close();">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-2"></div>		
	</div>
<?php } ?>
</div>
	
<script>
$(document).ready(function() {
  $("#showHide").click(function() {
	if ($("#new_Password").attr("type") == "password") {
      $("#new_Password").attr("type", "text");

    } else {
      $("#new_Password").attr("type", "password");
    }
  });
});
$('#new_Password').blur(function()
{
	if( $('#new_Password').val() == "" || $('#new_Password').val() == 0 )
	{
		$("#new_Password").val("");
		has_error("#has-feedback2","#glyphicon2","#help-block2","New Password should not be blank.");
	}
	else
	{
		has_success("#has-feedback2","#glyphicon2","#help-block2"," ");
	}
});
		
$('#confirm_Password').blur(function()
{
	if( $('#confirm_Password').val() == "" || $('#confirm_Password').val() == 0 )
	{
		$("#confirm_Password").val("");
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should not be blank.");
	}
	else 	if( $('#new_Password').val() !=  $('#confirm_Password').val())
	{
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be same as New Password.");
	}
	else
	{
		has_success("#has-feedback3","#glyphicon3","#help-block3"," ");
	}
});
$("#change_pwd").click(function()
{	
	var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	// var special = new RegExp("/^[a-zA-Z0-9- ]*$/");
	var new_password=$("#new_Password").val();
	var Confirm_Password=$("#confirm_Password").val();
	// alert("Change_password");
	if(new_password == "" )
	{
		has_error("#has-feedback21","#glyphicon21","#help-block21","New Password should not be blank.");		
		return false;
	}
	else{
		
		/* $("#glyphicon21").removeClass("glyphicon glyphicon-remove");
		$("#glyphicon21").addClass("glyphicon glyphicon-ok"); */
		has_success("#has-glyphicon21","#glyphicon21","#help-block21"," ");
	}	
	if(Confirm_Password == "" )
	{
		has_error("#has-feedback20","#glyphicon20","#help-block20","Confirm Password should not be blank.");		
		return false;
	} else {
		
		// $("#feedback20").removeClass("glyphicon glyphicon-remove");
		// $("#feedback20").addClass("glyphicon glyphicon-ok");
		
		has_success("#has-feedback20","#glyphicon20","#help-block20"," ");
	}
	var Error_count=0;
	
		if(new_password.length >= 8 )
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
		// alert('----Error_count------'+Error_count);
		var n = Confirm_Password.localeCompare(new_password);
		if( n == 0 )
		{
			// alert('----n--if----'+n);
			
			show_loader();
			
			Change_password(new_password,Confirm_Password)
			return true;
			// document.getElementById("password_match").style.display="";
		}
		else
		{
			// alert('----n---else---'+n);
			// $('#password_match').modal('show');
			// document.getElementById("password_match").style.display="";
			has_error("#has-feedback22","#glyphicon22","#help-block22","Confirm Password should be same as New Password.");
			return false;
		}
		return true;
	}
	else
	{
		return false;
	}
});
function Change_password(new_Password,confirm_Password)
{
	var csrfName = $('.txt_csrfname').attr('name'); 
	var csrfHash = $('.txt_csrfname').val(); 

	// alert("Confirm Password should be same as New Password.");
	if( $('#new_Password').val() !=  $('#confirm_Password').val())
	{
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be same as New Password.");
		return false;
	}
	else if($('#new_Password').val() == "" && $('#confirm_Password').val() == "")
	{
		has_error("#has-feedback2","#glyphicon2","#help-block2","New Password should not be blank.");
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be blank.");
		return false;
	}
	else 
	{
		show_loader();
		var SetCompany_id = '<?php echo $Pwd_variables["Company_id"]; ?>';
		var SetEnroll_id = '<?php echo $Pwd_variables["Enroll_id"]; ?>';		
		var Pwd_set_code = '<?php echo $Pwd_variables["Pwd_set_code"]; ?>';		
		
		$.ajax
		({
			type: "POST",
			async: false,
			data:{new_Password:new_Password,confirm_Password:confirm_Password,SetEnroll_id:SetEnroll_id,SetCompany_id:SetCompany_id,Pwd_set_code:Pwd_set_code,[csrfName]:csrfHash},
			url: "<?php echo base_url()?>index.php/Login/bc1fadea",
			success: function(data)
			{
				if(data == 1)
				{								
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Password Updated Successfuly',
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								window.close();
							}
						}]
					});								
				} 
				else if(data == 0)
				{
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Password Not Updated',
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								window.close();
							}
						}]
					});
				}
				else if(data == 2)
				{
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Old Password is same with New Password.. Please try again',
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								window.close();
							}
						}]
					});
				}
				else if(data == 3)
				{
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: "New Password and Confirm Password don't match..Please try again",
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								window.close();
							}
						}]
					});
				}
				else if(data == 4)
				{
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: "Password should be minimum of 8 characters with one number, one special, one upper and one lower case letter",
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								window.close();
							}
						}]
					});
				}
				else if(data == 5)
				{
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: "The link that you are trying to view is already accessed. It can be viewed and used only once and is then destroyed.",
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								window.close();
							}
						}]
					});
				}
			}
		});
	}
}
$( document ).ready( function() {
	$('.carousel').carousel();
});
</script>
</body>
</html>
<style>
body {
 background-image: url("<?php echo base_url();?>foodassets/img/slide.jpg"); 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
   background-repeat: no-repeat;
}
.card{
	background-color: #fff;
}
</style>
<style>
.glyphicon-ok{
	color: green;
}
.glyphicon-remove
{
	color: red;
}
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
@font-face {
    font-family: 'Glyphicons Halflings';
    src: url('<?php echo base_url()?>/assets/fonts/glyphicons-halflings-regular.eot');
    src: url('<?php echo base_url()?>/assets/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), 
	url('<?php echo base_url()?>/assets/fonts/glyphicons-halflings-regular.woff') format('woff'), 
	url('<?php echo base_url()?>/assets/fonts/glyphicons-halflings-regular.ttf') format('truetype'), 
	url('<?php echo base_url()?>/assets/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
}
</style>