<?php $this->load->view('front/header/header'); 
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}	
$Photograph = $Enroll_details->Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}
?>
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url();?>index.php/Cust_home/myprofile?page=3"><span>Change Password</span></a>
				</div>
				
			</div>
		</div>
	</header>
	<div class="custom-body">
			<div class="container">
				<div class="profile-box">
					<div class="avtar sm">
						<img src="<?php echo $Photograph;?>" alt=""/>
					</div>
					<h2><?php echo ucwords($Enroll_details->First_name).' '.ucwords($Enroll_details->Last_name);?></h2>
					<!-- <h4>Silver Member</h4> -->
					<div class="point">
						<span><?php echo $Current_point_balance.' Points'; ?> <?php //echo $Company_Details->Currency_name;; ?></span>
					</div>
					
				</div>
				
			</div>
			<div class="login-box">
			<?php
					if(@$this->session->flashdata('error_code'))
					{
					?>
						<div class="alert bg-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
					<?php
					}
				?>
				
				 <?php 
				 $data = array('onsubmit' => "return Change_password()");  
				echo form_open_multipart('Cust_home/changepassword', $data); ?>
				<div class="form-group">
					<div class="field-icon">
						<div class="inputpasseye">
						<input type="password" name="old_Password" id="old_Password" class="form-control" required placeholder="Old Password"/>
						<div class="input-group-addon"> <i toggle="#old_Password" class="fa fa-eye-slash visiblepass" aria-hidden="true"></i>
						</div>	
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.968" height="15.967" viewBox="0 0 15.968 15.967"><g transform="translate(27.636 27.625) rotate(180)"><path d="M26.091,13.2a5.271,5.271,0,0,0-8.485,6l-5.5,5.5a.441.441,0,0,0-.124.248l-.311,2.175a.44.44,0,0,0,.5.5l2.176-.31a.439.439,0,0,0,.377-.435v-.8h.8a.439.439,0,0,0,.439-.439v-.8h.8a.439.439,0,0,0,.311-.129l3.012-3.012a5.271,5.271,0,0,0,6-8.485Zm-.621,6.836a4.406,4.406,0,0,1-5.247.727.442.442,0,0,0-.525.073l-3.111,3.11H15.526a.439.439,0,0,0-.439.439v.8h-.8a.439.439,0,0,0-.439.439v.862l-1.218.174.207-1.45L18.455,19.6a.439.439,0,0,0,.073-.525,4.393,4.393,0,1,1,6.942.968Z" transform="translate(0 0)" fill="#b7b7b7"/><path d="M58.512,22.581a1.758,1.758,0,1,0,2.485,0,1.8,1.8,0,0,0-2.485,0Zm1.864,1.864a.9.9,0,0,1-1.243,0,.879.879,0,1,1,1.243,0Z" transform="translate(-36.15 -8.134)" fill="#b7b7b7"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="help-block" style="float:center;"></div>
					</div>
				</div>
			</div>
				<div class="form-group">
					<div class="field-icon">
						<div class="inputpasseye">
						<input type="password" name="new_Password"  id="new_Password"  class="form-control" placeholder="New Password" required />
						<div class="input-group-addon"> <i toggle="#new_Password" class="fa fa-eye-slash visiblepass" aria-hidden="true"></i>
						</div>
						
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.968" height="15.967" viewBox="0 0 15.968 15.967"><g transform="translate(27.636 27.625) rotate(180)"><path d="M26.091,13.2a5.271,5.271,0,0,0-8.485,6l-5.5,5.5a.441.441,0,0,0-.124.248l-.311,2.175a.44.44,0,0,0,.5.5l2.176-.31a.439.439,0,0,0,.377-.435v-.8h.8a.439.439,0,0,0,.439-.439v-.8h.8a.439.439,0,0,0,.311-.129l3.012-3.012a5.271,5.271,0,0,0,6-8.485Zm-.621,6.836a4.406,4.406,0,0,1-5.247.727.442.442,0,0,0-.525.073l-3.111,3.11H15.526a.439.439,0,0,0-.439.439v.8h-.8a.439.439,0,0,0-.439.439v.862l-1.218.174.207-1.45L18.455,19.6a.439.439,0,0,0,.073-.525,4.393,4.393,0,1,1,6.942.968Z" transform="translate(0 0)" fill="#b7b7b7"/><path d="M58.512,22.581a1.758,1.758,0,1,0,2.485,0,1.8,1.8,0,0,0-2.485,0Zm1.864,1.864a.9.9,0,0,1-1.243,0,.879.879,0,1,1,1.243,0Z" transform="translate(-36.15 -8.134)" fill="#b7b7b7"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="help-block2" style="float:center;"></div>
					</div>
				</div>
			</div>
				<div class="form-group">
					<div class="field-icon">
						<div class="inputpasseye">
						<input type="password" name="confirm_Password"   id="confirm_Password" class="form-control" placeholder="Confirm Password" required />
						<div class="input-group-addon"> <i toggle="#confirm_Password" class="fa fa-eye-slash visiblepass" aria-hidden="true"></i>
						</div>
						
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.968" height="15.967" viewBox="0 0 15.968 15.967"><g transform="translate(27.636 27.625) rotate(180)"><path d="M26.091,13.2a5.271,5.271,0,0,0-8.485,6l-5.5,5.5a.441.441,0,0,0-.124.248l-.311,2.175a.44.44,0,0,0,.5.5l2.176-.31a.439.439,0,0,0,.377-.435v-.8h.8a.439.439,0,0,0,.439-.439v-.8h.8a.439.439,0,0,0,.311-.129l3.012-3.012a5.271,5.271,0,0,0,6-8.485Zm-.621,6.836a4.406,4.406,0,0,1-5.247.727.442.442,0,0,0-.525.073l-3.111,3.11H15.526a.439.439,0,0,0-.439.439v.8h-.8a.439.439,0,0,0-.439.439v.862l-1.218.174.207-1.45L18.455,19.6a.439.439,0,0,0,.073-.525,4.393,4.393,0,1,1,6.942.968Z" transform="translate(0 0)" fill="#b7b7b7"/><path d="M58.512,22.581a1.758,1.758,0,1,0,2.485,0,1.8,1.8,0,0,0-2.485,0Zm1.864,1.864a.9.9,0,0,1-1.243,0,.879.879,0,1,1,1.243,0Z" transform="translate(-36.15 -8.134)" fill="#b7b7b7"/></g></svg>
						</div>
						<div class="line"></div>
					</div>
					<p class="note">Password should be minimum of 6 characters with one number, one special, one upper and one lower case letter</p>
				</div>
				</div>
				<div class="submit-field">
					<button type="submit" class="submit-btn">Submit</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
<?php $this->load->view('front/header/footer');  ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<!--Click to Show/Hide Input Password JS-->
	<script type="text/javascript">
		$(".visiblepass").click(function()
		{
		  $(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") 
		  {
		    input.prop("type", "text");
		  } 
		  else 
		  {
		    input.prop("type", "password");
		  }
		});
		
		function Change_password()
		{ 
			var ucase = new RegExp("[A-Z]+");
			var lcase = new RegExp("[a-z]+");
			var special = new RegExp("[#-z]+");
			var num = new RegExp("[0-9]+");
			var old_Password=$("#old_Password").val();
			var new_password=$("#new_Password").val();
			var Confirm_Password=$("#confirm_Password").val();
			var Error_count=0;
			
			/* console.log($('#new_Password').val().indexOf('#'));
			console.log($('#new_Password').val().indexOf('%'));
			console.log($('#new_Password').val().indexOf('&'));
			console.log($('#new_Password').val().indexOf('+'));
			console.log($('#new_Password').val().indexOf('='));
			return false; */
			
			
			if($('#new_Password').val().indexOf('#') !== -1)
			{
				Error_count++;
				
				var msg = 'Can not use # % & + and = characters for security purpose.';
				$('.help-block2').show();
				$('.help-block2').css("color","red");
				$('.help-block2').css("font-size","10px");
				$('.help-block2').css("line-height","20px");
				$('.help-block2').html(msg);
				setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				return false;
				
			} else {	
			}
			if($('#new_Password').val().indexOf('%') !== -1)
			{
				Error_count++;
				
				var msg = 'Can not use # % & + and = characters for security purpose.';
				$('.help-block2').show();
				$('.help-block2').css("color","red");
				$('.help-block2').css("font-size","10px");
				$('.help-block2').css("line-height","20px");
				$('.help-block2').html(msg);
				setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				return false;
				
			} else {
			}
			if($('#new_Password').val().indexOf('&') !== -1)
			{
				Error_count++;
				
				var msg = 'Can not use # % & + and = characters for security purpose.';
				$('.help-block2').show();
				$('.help-block2').css("color","red");
				$('.help-block2').css("font-size","10px");
				$('.help-block2').css("line-height","20px");
				$('.help-block2').html(msg);
				setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				return false;
				
			} else {
				
				
				
			}
			if($('#new_Password').val().indexOf('+') !== -1)
			{
				Error_count++;
				
				var msg = 'Can not use # % & + and = characters for security purpose.';
				$('.help-block2').show();
				$('.help-block2').css("color","red");
				$('.help-block2').css("font-size","10px");
				$('.help-block2').css("line-height","20px");
				$('.help-block2').html(msg);
				setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				return false;
				
			} else {		
			}
			if($('#new_Password').val().indexOf('=') !== -1)
			{
				Error_count++;
				
				var msg = 'Can not use # % & + and = characters for security purpose.';
				$('.help-block2').show();
				$('.help-block2').css("color","red");
				$('.help-block2').css("font-size","10px");
				$('.help-block2').css("line-height","20px");
				$('.help-block2').html(msg);
				setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				return false;
				
			} else {
				
			}
				if( $('#old_Password').val() == "" || $('#old_Password').val() == null )
				{
					var msg = 'Please Fill Out Field.';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').css("font-size","10px");
					$('.help-block').css("line-height","20px");
					$('.help-block').html(msg);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
					return false;
				}
				else if($('#new_Password').val() == "" && $('#confirm_Password').val() == "")
				{
					var msg2 = 'Please Fill Out Field.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg2);
					
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
					return false;
				}
				else if( $('#new_Password').val() !=  $('#confirm_Password').val())
				{
					$("#confirm_Password").val("");	
					var msg1 = 'Confirm Password should be same as New Password.';
					$('.help-block1').show();
					$('.help-block1').css("color","red");
					$('.help-block1').css("font-size","10px");
					$('.help-block1').css("line-height","20px");
					$('.help-block1').html(msg1);
					setTimeout(function(){ $('.help-block1').hide(); }, 3000);
					return false;
				}


								
				if(new_password.length >= 6 )
				{}
				else
				{				
					Error_count++;
					// $("#new_Password").val("");	
					// $("#confirm_Password").val("");		
					var msg2 = 'Password should be greater than 6 digit.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg2);
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				}
				if(num.test(new_password) == true )
				{}
				else
				{											
					Error_count++;
					// $("#new_Password").val("");	
					// $("#confirm_Password").val("");		
					var msg2 = 'Password should be at least 1 number.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg2);
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				}
				if(ucase.test(new_password) == true )
				{}
				else
				{	
					Error_count++;
					// $("#new_Password").val("");	
					// $("#confirm_Password").val("");		
					var msg2 ='Password should be at least 1 uppercase.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg2);
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				}		
				if (/^[a-zA-Z0-9- ]*$/.test(new_password) == false) 
				{}
				else
				{	
					Error_count++;
					// $("#new_Password").val("");	
					// $("#confirm_Password").val("");		
					var msg2 ='Password should match critria.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg2);
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				}
				if(lcase.test(new_password) == true  )
				{}
				else
				{	
					Error_count++;
					// $("#new_Password").val("");	
					// $("#confirm_Password").val("");		
					var msg2 ='Password should be at least 1 lowercase.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg2);
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
				}	
			if(Error_count == 0)
			{	
				var n = Confirm_Password.localeCompare(new_password);
				if( n == 0 )
				{
					/* setTimeout(function() 
					{
						$('#myModal').modal('show'); 
					}, 0);
					setTimeout(function() 
					{ 
						$('#myModal').modal('hide'); 
					},2000); */
					
					// document.Change_Pswd.submit();
					
					return true;	
				}
				else
				{
					return false;
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		
		
		$('#old_Password').blur(function()
		{	
			var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
			var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
			var old_Password = $('#old_Password').val();
			
			if( $("#old_Password").val() == "" )
			{
				var msg = 'Old Password does not Match.';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').css("font-size","10px");
				$('.help-block').css("line-height","20px");
				$('.help-block').html(msg);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
			}
			else
			{
				$.ajax({
					type: "POST",
					data: { old_Password: old_Password, Company_id:Company_id,Enrollment_id: Enrollment_id},
					url: "<?php echo base_url()?>index.php/Cust_home/checkoldpassword",
					success: function(data)
					{				
						if(data == 0)
						{ 
							$("#old_Password").val("");	
							var msg1 = 'Please Enter Correct Password.';
							$('.help-block').show();
							$('.help-block').css("color","red");
							$('.help-block').css("font-size","10px");
							$('.help-block').css("line-height","20px");
							$('.help-block').html(msg1);
							setTimeout(function(){ $('.help-block').hide(); }, 3000);
						}
						else
						{
						}
					}
				});
			}
		});
		/*------------15-06-2020-----------*/
		 /* $('#new_Password').bind('keypress', function(e) {
			if($('#new_Password').val().length >= 0){
				alert('new_Password');
				if (e.which == 35 || e.which == 37 || e.which == 38 || e.which == 43 || e.which == 61){//space bar
					// e.preventDefault();
					
					var msg = 'Can not use # % & + and = characters for security purpose.';
					$('.help-block2').show();
					$('.help-block2').css("color","red");
					$('.help-block2').css("font-size","10px");
					$('.help-block2').css("line-height","20px");
					$('.help-block2').html(msg);
					setTimeout(function(){ $('.help-block2').hide(); }, 3000);
					return false;			
				} else {
					// alert('False');
				}
			}
		});  */
		/*------------15-06-2020-----------*/
	</script>