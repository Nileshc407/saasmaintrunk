<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
$ci_object->load->model('Users_model');
?>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>

<?php echo form_open_multipart('Cust_home/contactus');	?>
<?php
	if(@$this->session->flashdata('Contactus'))
	{
	?>
		<script>
			var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('Contactus'); ?>';
			runjs(Title,msg);
		</script>
	<?php
	}	
?>

<section class="content-header">
	<h1>Contact Us</h1>          
</section>

        <!-- Main content -->
        <section class="content">
		
         <div class="row">
		  <div class="login-box">
			  <div class="login-box-body">
				<form action="#" method="post">
					
					<div class="form-group has-feedback">
					<label for="exampleInputPassword1">Select Subject for the Message</label>
                      <select class="form-control" name="contact_subject" id="contact_subject"  onchange="hide_query_type(this.value);" required>
								<option value="" >Select Message Subject</option>
								<option value="1" >Feedback</option>
								<option value="2" >Request</option>
								<option value="3" >Suggestion</option>
								<?php if($Call_center_flag == 1) { ?>
								<option value="4">Call center ticket raise</option>
								<?php }?>
					</select>						
					<div class="help-block"></div>
					<div id="query_type1" style="display:none">
							<label for="exampleInputEmail1"> <span class="required_info">*</span> Query Type  </label>
							<select class="form-control" name="Query_Type" id="Query_Type" required>
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
							<div class="help-block"></div>
							<label for="exampleInputEmail1"><span class="required_info">*</span> Sub Query Type  </label>
							<select class="form-control" id="Sub_query_type" name="Sub_query_type" required>
							<option value="">Select Sub Query </option>
							</select>
					</div>
				</div>
					<div class="form-group has-feedback">
					<label for="exampleInputEmail1"><div id="Message_lbl"><span class="required_info">*</span>  Enter Message Details</div></label>
					<textarea class="form-control" rows="4" name="offerdetails" id="offerdetails1" placeholder="Enter Message Details" ></textarea>
					</div>
			  <div class="row">				
				 <div class="col-xs-12">				 
					<button type="submit" class="btn btn-primary btn-block btn-flat" id="submit" name="submit" >Submit</button>
					<button type="reset" class="btn btn-primary btn-block btn-flat">Reset</button>
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						  <input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						  <input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						  
						  <input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
				</div>
				<!-- /.col -->
				<div class="col-xs-4">
					
				</div><!-- /.col -->
			  </div>
			</form>
			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
		</div>   <!-- /.row -->
		  
			  
		<?php echo form_close(); ?>
        </section><!-- /.content -->
      <?php $this->load->view('header/footer');?>
	  
<style>
.login-box{
	margin: 2% auto;
}
</style>

<script>	
	function fileBrowserCallBack(field_name, url, type, win)
	{
		$('.mce-window').css("z-index","0");
		$('.modal').css("z-index","9999999");
		$('#ImageModal').show();
		$("#ImageModal").addClass( "in" );	
		$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );		
	}
	
	tinymce.init(
	{
		selector: "textarea#contactus",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview media code | forecolor backcolor emoticons",	//link image |
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails1]').val(htmlContent);
			});
		}
	});
	
	tinymce.init(
	{
		selector: "textarea#offerdetails1",
		theme: "modern",
		height : 200,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "preview",			
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				$('input[name=contactus]').val(htmlContent);
			});
		}
	});	
<!--------------------------------Call Center---------------------------------->
function hide_query_type(input_val)
{
	if(input_val == 4)
	{
		$("#query_type1").show();
		document.getElementById('Message_lbl').innerHTML = "* Enter Query Details";
	}
	else
	{
		document.getElementById('Message_lbl').innerHTML = "* Enter Message Details";
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
		url: "<?php echo base_url()?>index.php/Cust_home/Get_Sub_Query",
		
		success: function(data)
		{
			$('#Sub_query_type').html(data.Get_Sub_query_Names1);		
		}				
	});
});		
</script>
<!--------------------------------Call Center---------------------------------->
<!--------------------------------Chat Box---------------------------------->
</script>
<?php if($Call_center_flag == 1) { ?>
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/css/screen.css" /> 
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/css/chat.css"  />
<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.js"></script>
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
	.html('<a href="javascript:void(0)"  style="color:white !important;" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"><div class="chatboxhead" ><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"> <div id="p1"><i class="fa fa-sort-asc"></i></div></div> <div class="chatboxoptions2" style="display:none"> <div id="p2" style="display:none"><i class="fa fa-sort-desc"></i></div></div> </a><br clear="all"/></div><div id="chatboxcontent" class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
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
<!------------------------------Chat Box------------------------------->