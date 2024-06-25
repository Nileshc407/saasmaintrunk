<!DOCTYPE html>
<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
$ci_object->load->model('Users_model');
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<html lang="en">
<head>
<title>Contact Us</title>	
<?php $this->load->view('front/header/header'); ?> 
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>
</head>
<body>        
<form  name="contact_us" method="POST" action="<?php echo base_url()?>index.php/Cust_home/contactus_App" enctype="multipart/form-data" onsubmit="return form_submit();">	
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
      <div class="container">
        <div class="section-header">          
			<p><a href="<?php echo base_url();?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Contact Us</p>
		</div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12"> 
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
              <img src="<?php echo base_url(); ?>assets/icons/contact.jpg" class="img-responsive" style="width:50%; border-radius: 3%;">          
              <div class="pricing-details">
                <ul><br/>
                  <li id="Small_font" class="text-left">
					  <select class="txt"  id="Sub_line" name="contact_subject" onchange="hide_query_type(this.value);" >
					  <option value="" >Select Message Subject</option>
						<option value="1">Feedback</option>
						<option value="2">Request</option>
						<option value="3">Suggestion</option>
						<?php if($Call_center_flag == 1) { ?>
						<option value="4">Call center ticket raise</option>
						<?php }?>
					  </select>
					  <div class="help-block" style="float: center;"></div>
				  </li><hr>
				  
					<div id="query_type1" style="display:none">
						<li id="Small_font" class="text-left">
							<select class="txt" name="Query_Type" id="Query_Type" >
							<option value="">Select Query Type</option>
							<?php	
							if($query_type != NULL)
							{
							foreach($query_type as $query_type)
							{	
							?>
							<option value="<?php echo $query_type->Query_type_id; ?>"><?php echo $query_type->Query_type_name; ?></option>
							<?php
							}
							}
							?>
							</select>
							 <div class="help-block1" style="float: center;"></div>
						</li><hr>
						<li id="Small_font" class="text-left">
							<select  class="txt" id="Sub_query_type" name="Sub_query_type" > 
							<option value="">Select Sub Query </option>
							</select>
							 <div class="help-block2" style="float: center;"></div>
						</li><hr>
					</div>
					  <li class="text-left">
							
							<textarea class="txt"  rows="2" cols="50" name="offerdetails" id="message_detail"placeholder="Enter details" ></textarea>
					  </li>
					  <li style="text-align: center;">
						<button type="submit" id="button">Submit</button>
					  </li>
                </ul>
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" />
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" />
					<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>"/>
					<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" />
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Pricing Table Section -->
	
	<!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
    <!-- Loader -->
</form>
<?php $this->load->view('front/header/footer'); ?> 
<script>
<!--------------------------------Call Center---------------------------------->

function hide_query_type(input_val)
{
	if(input_val == 4)
	{
		$("#query_type1").show();
		// document.getElementById('Message_lbl').innerHTML = "Enter Query Details";
		// $("#Message_lbl").css('color','<?php echo $Small_font_details[0]['Small_font_color']; ?>');
		// $("#Message_lbl").css('font-family','<?php echo $Small_font_details[0]['Small_font_family']; ?>');
		// $("#Message_lbl").css('font-size','<?php echo $Small_font_details[0]['Small_font_size']; ?>');	
	}
	else
	{
		// document.getElementById('Message_lbl').innerHTML = "Enter Message Details";
		// $("#Message_lbl").css('color','<?php echo $Small_font_details[0]['Small_font_color']; ?>');
		// $("#Message_lbl").css('font-family','<?php echo $Small_font_details[0]['Small_font_family']; ?>');
		// $("#Message_lbl").css('font-size','<?php echo $Small_font_details[0]['Small_font_size']; ?>');
		$("#query_type1").hide();
		$("#Query_Type").removeAttr("required");
		$("#Sub_query_type").removeAttr("required");
	}
}
$('#Query_Type').change(function()
{	
	var Query_Type = $("#Query_Type").val();
	var Company_id = '<?php echo $Company_id ; ?>';
	
	$.ajax({
		type:"POST",
		data:{QueryTypeId:Query_Type, Company_id:Company_id},
		url: "<?php echo base_url();?>index.php/Cust_home/Get_Sub_Query_App",
		
		success: function(data)
		{
			$('#Sub_query_type').html(data.Get_Sub_query_Names1);		
		}				
	});
});	
function form_submit()
{
	var Sub_line=$("#Sub_line").val();
	
	if( $("#Sub_line").val() == "" )
	{
		var msg1 = 'Please Select Message Subjet.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	else if( $("#Sub_line").val() == 4 )
	{
		if( $("#Query_Type").val() == "" )
		{
			var msg2 = 'Please Select Query Type.';
			$('.help-block1').show();
			$('.help-block1').css("color","red");
			$('.help-block1').html(msg2);
			setTimeout(function(){ $('.help-block1').hide(); }, 3000);
			return false;
		
		}
		else if( $("#Sub_query_type").val() == "" )
		{
			var msg3 = 'Please Select Sub Query Type.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg3);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
			return false;
		}
	}
	if( $("#Sub_line").val() != "")
	{
		setTimeout(function() 
		{
			$("#myModal").modal("show"); 
		}, 0);
		setTimeout(function() 
		{ 
			$("#myModal").modal("hide"); 
		},2000);
	
		// document.contact_us.submit(); // submit
	}	
}	
</script>
<style>
	.Small_font
	{ 	color:<?php echo $Small_font_details[0]['Small_font_color']; ?>;
		font-family:<?php echo $Small_font_details[0]['Small_font_family']; ?>;
		font-size:<?php echo $Small_font_details[0]['Small_font_size']; ?>;
	}
	
	@media (max-width: 480px) and (min-width: 320px)
	.section-header .section-title {
		font-size: 20px;
		line-height: 30px;
	}
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 13px;
		border-bottom: none;
		color: #7d7c7c;
	}
	.pricing-table .pricing-details span {
		display: inline-block;
		font-size: 13px;
		font-weight: 400;
		color: #000000;
		margin-bottom: 20px;
	}
	
	h1, h2, h3, h4, h5, h6 {
		margin-top: 10px;
	}	
.custom-form 
{
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  font-size: 16px;
  max-width: 360px;
  margin: 40px auto 40px;
  background: #fff;
  padding: 40px;
  border-radius: 4px;
 .btn-primary {
  background-color: #8e44ad;
  border-color: #8e44ad;
  }
  .form-group 
  {
    position: relative;
    padding-top: 16px;
    margin-bottom: 16px;
    .animated-label {
      position: absolute;
      top: 20px;
      left: 0;
      bottom: 0;
      z-index: 2;
      width: 100%;
      font-weight: 300;
      opacity: 0.5;
      cursor: text;
      transition: 0.2s ease all;
      margin: 0;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
      &:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 45%;
        height: 2px;
        width: 10px;
        visibility: hidden;
        background-color:#8e44ad;
        transition: 0.2s ease all;
      }
    }
    &.not-empty {
      .animated-label {
        top: 0;
        font-size: 12px;
      }
    }
    .form-control {
      position: relative;
      z-index: 1;
      border-radius: 0;
      border-width: 0 0 1px;
      border-bottom-color: rgba(0,0,0,0.25);
      height: auto;
      padding: 3px 0 5px;
      &:focus {
        box-shadow: none;
        border-bottom-color: rgba(0,0,0,0.12);
        ~ .animated-label {
          top: 0;
          opacity: 1;
          color: #8e44ad;
          font-size: 12px;
          &:after {
            visibility: visible;
            width: 100%;
            left: 0;
          }
        }
      }
    }
  }
}
	.X{
		color:#1fa07f;
	}
	#icon
	{
		width: 6%;
		margin-top: 2%;
	}
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 4% 1% 2% 1%;		
		width: 100%;
		margin-left: 0%;		
	}
	.txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 4% 1% 2% 1%;		
		width: 100%;
		margin-left: 0%;		
	}
	#action
	{
	  color: #ff3399;
	  width:100%;
	  height:30px;
	  outline: none;
	}
	.action
	{
	  color: #ff3399;
	  width:100%;
	  height:30px;
	  outline: none;
	}
	
	::placeholder 
	{
		color: #bfbfba;
	}
	 
</style>
<!--------------------------------Chat Box---------------------------------->
</script>
<?php if($Call_center_flag == 1) { ?>
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/css/screen.css" /> 
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/css/chat.css"  />
<script src="<?php echo $this->config->item('base_url2');?>assets/js/jquery.js"></script>

<?php
$session_data = $this->session->userdata('cust_logged_in');
$Cust_email_id = $session_data['username'];			
$enrollId = $session_data['enroll'];
$Company_id = $session_data['Company_id'];

$userId = 6;
$Sub_seller_admin =0;
	$get_enrollment2 = $ci_object->Users_model->get_enrollment_details($userId,$Sub_seller_admin,$Company_id);
		if($get_enrollment2 != NULL)
		{
			$support_email = $get_enrollment2->User_email_id;
		}
		else
		{
			$support_email = $Company_contactus_email_id;
		}
		$get_enrollment = $ci_object->Igain_model->get_enrollment_details($enrollId);

		$Cust_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;

		$listOfUsers = $ci_object->Users_model->getUsers($Company_id);
	
		if($listOfUsers != NULL)
		{
			foreach($listOfUsers as $res)
			{
			
				$get_enrollment1 = $ci_object->Igain_model->get_enrollment_details($res['enrollId']);
				$login_userId1 = $res['enrollId'];
				$User_email_id1 = $get_enrollment1->User_email_id;
				$login_userName1 = $get_enrollment1->First_name.' '.$get_enrollment1->Last_name;
				/*------------------------Set User Value in Session-------------------------*/	
				$_SESSION["login_userId"] = $login_userId1;
				$_SESSION['User_email_id'] = $User_email_id1;
				$_SESSION['login_userName'] = $login_userName1;
				/*------------------------Set User Value in Session-------------------------*/
				
			} 
		} 
				$login_userId2 = $_SESSION['login_userId'];
				$chackuser = $ci_object->Users_model->Chack_user_status($login_userId2,$Company_id);
				if($chackuser != NULL)
				{
					$login_userId = $_SESSION['login_userId'];
					$User_email_id = $_SESSION['User_email_id'];
					$login_userName = $_SESSION['login_userName'];		
				}
				else
				{
					$login_userId = "";
					$User_email_id = "";
					$login_userName = "";
				}
	}
	?>	  	  			  
<style>
.login-box
{
	margin: 2% auto;
}
.chatbox {
	margin-bottom: 62px;
    margin-right: 0px;
}
</style>
<?php if($Call_center_flag == 1) { ?>
<script>

var windowFocus 		= true;
var username;
var chatHeartbeatCount 	= 0;
var minChatHeartbeat 	= 3000;
var maxChatHeartbeat 	= 5000;
var chatHeartbeatTime 	= minChatHeartbeat;
var originalTitle;
var blinkOrder 			= 0;

var chatboxFocus 		= new Array();
var newMessages 		= new Array();
var newMessagesWin 		= new Array();
var chatBoxes 			= new Array();

jQuery.noConflict();

jQuery(document).ready(function()
{	
	originalTitle = document.title;
	startChatSession();
});
//*****************************************************************************************************
	// restructureChatBoxes
//*****************************************************************************************************
function restructureChatBoxes() 
{
	align = 0;
	for (x in chatBoxes) 
	{
		chatboxtitle = chatBoxes[x];

		if (jQuery("#chatbox_"+chatboxtitle).css('display') != 'none')
		{
			if (align == 0) {
				jQuery("#chatbox_"+chatboxtitle).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				jQuery("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}
//*****************************************************************************************************
	// createChatBox
//*****************************************************************************************************
function createChatBox(chatboxtitle,minimizeChatBox) 
{		
	if (jQuery("#chatbox_"+chatboxtitle).length > 0) 
	{		
		if (jQuery("#chatbox_"+chatboxtitle).css('display') == 'none') 
		{		
			jQuery("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}
	jQuery(" <div style='margin-left:50% !important;'/>" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<a href="javascript:void(0)"  style="color:white !important;" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"><div class="chatboxhead" ><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"> <div id="p1"><b>^</b></div></div> <div class="chatboxoptions2" style="display:none"> <div id="p2" style="display:none">v</div></div> </a><br clear="all"/></div><div id="chatboxcontent" class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	.appendTo(jQuery( "body" ));
			   
	jQuery("#chatbox_"+chatboxtitle).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) 
	{
		if (jQuery("#chatbox_"+chatBoxes[x]).css('display') != 'none') 
		{
			chatBoxeslength++;
		}
	}
	if (chatBoxeslength == 0) 
	{
		jQuery("#chatbox_"+chatboxtitle).css('right', '20px');
	} 
	else 
	{
		width = (chatBoxeslength)*(225+7)+20;
		jQuery("#chatbox_"+chatboxtitle).css('right', width+'px');
	}	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) 
	{
		minimizedChatBoxes = new Array();

		if (jQuery.cookie('chatbox_minimized')) 
		{
			minimizedChatBoxes = jQuery.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) 
		{
			if (minimizedChatBoxes[j] == chatboxtitle) 
			{
				minimize = 1;
			}
		}
		if (minimize == 1) 
		{
			jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			jQuery('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}
	chatboxFocus[chatboxtitle] = false;

	jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function()
	{
		chatboxFocus[chatboxtitle] = false;
		jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function()
	{
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		jQuery('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	jQuery("#chatbox_"+chatboxtitle).click(function() {
		if (jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') 
		{
			jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	jQuery("#chatbox_"+chatboxtitle).show();
}
//*****************************************************************************************************
	// chatHeartbeat
//*****************************************************************************************************
function startChatSession()
{  
		var enrollId= '<?php echo $enrollId; ?>';
		var from_name= '<?php echo $Cust_name; ?>';
		var Cust_email_id= '<?php echo $Cust_email_id; ?>';
		var Company_id= '<?php echo $Company_id; ?>';
		$.ajax({
		type: "POST", 
		data: {Company_id:Company_id,Cust_email_id:Cust_email_id,from:from_name},
		url: "<?php echo base_url()?>index.php/Chat/getchatsall",
		success: function(data)
		{ 
			var msg=data.split('*');
			<?php
			if($login_userId != NULL)
			{ ?>
				var chatboxtitle = 'Online';
			<?php
			}
			else
			{
			?>
				var chatboxtitle = 'Offline';
			<?php
			}
			?>
			if (jQuery("#chatbox_"+chatboxtitle).length <= 0) 
			{
				createChatBox(chatboxtitle,1);
			}			
			for(var i=0;i<msg.length;i++)
			{
				var message=msg[i];
				
				if(message == 9999)
				{		
				<?php if($login_userName !="") { ?>
					var message= "<b><?php echo $login_userName.',</b> Welcome... How May I Help You..!!';
				?>"; 
				<?php
				}
				else
				{ ?>
					var message ="&nbsp&nbsp Sorry, There is no any user online Please contact on Call center Number, Or Support Email - <?php echo '<b><u>'.$support_email.'</u></b>'; ?>";
		<?php	}
				?>
				}
				jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom"></span><span class="chatboxmessagecontent">'+message+'</span></div>');
			}
			var t=window.setTimeout('chatHeartbeat();',chatHeartbeatTime);				
		}
	});					
}
function chatHeartbeat()
{
		var itemsfound = 0;	
		if (windowFocus == false) 
		{
			var blinkNumber = 0;
			var titleChanged = 0;
			for (x in newMessagesWin) 
			{
				if (newMessagesWin[x] == false) 
				{
					++blinkNumber;
					if (blinkNumber >= blinkOrder) 
					{
						document.title = x+' says...';
						titleChanged = 1;
						break;	
					}
				}
			}		
			if (titleChanged == 0) 
			{
				document.title = originalTitle;
				blinkOrder = 0;
			} 
			else 
			{
				++blinkOrder;
			}
		} 
		else
		{
			for (x in newMessagesWin) 
			{
				newMessagesWin[x] = false;
			}
		}
		for (x in newMessages) 
		{
			if (newMessages[x] == true) 
			{
				if (chatboxFocus[x] == false) 
				{
					jQuery('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
					var audio = new Audio("<?php echo $this->config->item('base_url2');?>assets/audio/1sound.mp3");
					audio.play();
				}
			}
		}
		
		var enrollId= '<?php echo $enrollId; ?>';	
		var from_name= '<?php echo $Cust_name; ?>';
		var Cust_email_id= '<?php echo $Cust_email_id; ?>';
		var Company_id= '<?php echo $Company_id; ?>';
		$.ajax({
		type: "POST",
		data: {Company_id:Company_id,Cust_email_id:Cust_email_id,from:from_name},
		url: "<?php echo base_url()?>index.php/Chat/getchatsnew",
		success: function(data)
		{
					 
			if(data!=1111)
			{				
			var msg=data.split('*');
			<?php 
			if($login_userId != NULL)
			{
			?>
				var chatboxtitle = 'Online';
			<?php
			}
			else
			{ ?>
				var chatboxtitle = 'Offline';
				
	<?php	}
			?>
			
			if (jQuery("#chatbox_"+chatboxtitle).length <= 0) 
			{
				createChatBox(chatboxtitle);
			}
				
			/************************************************/
			if (jQuery("#chatbox_"+chatboxtitle).css('display') == 'none') 
			{
				jQuery("#chatbox_"+chatboxtitle).css('display','block');
				restructureChatBoxes();
			}
					
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					
					for(var i=0;i<msg.length;i++)
					{
						var message=msg[i];
			
						jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom"></span><span class="chatboxmessagecontent">'+message+'</span></div>');
			
					}			
				jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
		
				chatHeartbeatCount++;

				if (itemsfound > 0) 
				{
					chatHeartbeatTime = minChatHeartbeat;
					chatHeartbeatCount = 1;
				} 
				else if (chatHeartbeatCount >= 10)
				{
					chatHeartbeatTime *= 2;
					chatHeartbeatCount = 1;
					if (chatHeartbeatTime > maxChatHeartbeat) 
					{
						chatHeartbeatTime = maxChatHeartbeat;
					}
				}
			}
		}
	});	
	setTimeout('chatHeartbeat();',chatHeartbeatTime);		
}
//*****************************************************************************************************
	// toggleChatBoxGrowth
//*****************************************************************************************************
function toggleChatBoxGrowth(chatboxtitle) 
{
	if (jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') 
	{  	
		jQuery('.chatboxoptions').css('display','none');
		jQuery('.chatboxoptions2').css('display','block');
		
		document.getElementById('p2').setAttribute('style','display:block');
		document.getElementById('p1').setAttribute('style','display:none');
		
		var minimizedChatBoxes = new Array();
		
		if (jQuery.cookie('chatbox_minimized')) 
		{
			minimizedChatBoxes = jQuery.cookie('chatbox_minimized').split(/\|/);
		}
		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) 
			{
				newCookie += chatboxtitle+'|';
			}
		}
		newCookie = newCookie.slice(0, -1)
		jQuery.cookie('chatbox_minimized', newCookie);
		jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		jQuery('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	}
	else
	{	
		 jQuery('.chatboxoptions').css('display','block');
		 jQuery('.chatboxoptions2').css('display','none');
		 document.getElementById('p1').setAttribute('style','display:block');
		 document.getElementById('p2').setAttribute('style','display:none');
		 
		var newCookie = chatboxtitle;

		if (jQuery.cookie('chatbox_minimized')) {
			newCookie += '|'+jQuery.cookie('chatbox_minimized');
		}
		jQuery.cookie('chatbox_minimized',newCookie);
		jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		jQuery('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}	
}
//*****************************************************************************************************
	// checkChatBoxInputKey
//*****************************************************************************************************
function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) 
{
	if(event.keyCode == 13 && event.shiftKey == 0)  
	{ 
		var message = jQuery(chatboxtextarea).val();
		var message = message.replace(/^\s+|\s+$/g,"");
		var from_name = '<?php echo $Cust_name; ?>';
		var from_id = '<?php echo $enrollId; ?>';
		var Cust_email_id = '<?php echo $Cust_email_id; ?>';
		jQuery(chatboxtextarea).val('');
		jQuery(chatboxtextarea).focus();
		jQuery(chatboxtextarea).css('height','30px');
		if (message != '') 
		{		
			var login_userId = '<?php echo $login_userId; ?>';
			var login_userName = '<?php echo $login_userName; ?>'; 
			var User_email_id = '<?php echo $User_email_id; ?>'; 
			var Company_id = '<?php echo $Company_id; ?>'; 
		<?php
		if($login_userId != NULL)
		{ ?>
			$.ajax({
				type: "POST",
				data: {Company_id:Company_id,to_email_id:User_email_id,to_name:login_userName,message:message,from_email_id: Cust_email_id,from_name:from_name},
				url: "<?php echo base_url()?>index.php/Chat/insert_chat",
				success: function(data)
				{			
					 message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");			
					 jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+from_name+': </span><span class="chatboxmessagecontent">'+message+'</span></div>');
					jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);	
				}
			});
		<?php
		}
		else
		{
		  ?>		  
			var from_name ="";
			var message ="&nbsp&nbsp Sorry, There is no any user online Please contact on Call center Number, Or Support Email - <?php echo '<b><u>'.$support_email.'</u></b>'; ?>";
			 jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+from_name+'</span><span class="chatboxmessagecontent">'+message+'</span></div>');
					jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);	
		 <?php 
		}
		?>
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) 
	{
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			jQuery(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} 
	else 
	{
		jQuery(chatboxtextarea).css('overflow','auto');
	} 
}
//*****************************************************************************************************
	// startChatSession
//*****************************************************************************************************
<?php } ?>
</script>
<script>
jQuery.cookie = function(name,value,options) 
{
    if (typeof value != 'undefined') 
	{ 
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) 
		{
            var date;
            if (typeof options.expires == 'number') 
			{
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
       
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } 
	else 
	{ 
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '='))
				{
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
</script>

