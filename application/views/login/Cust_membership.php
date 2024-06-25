<?php 
$session_data = $this->session->userdata('logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$Loggin_User_id = $session_data['userId'];
$Allow_membershipid_once = $session_data['Allow_membershipid_once'];
$Allow_merchant_pin = $session_data['Allow_merchant_pin'];
$Company_id = $session_data['Company_id'];
$Company_name = $session_data['Company_name'];
$Merchant_pinno = $session_data['pinno'];
$Membership_redirection_url = $session_data['Membership_redirection_url'];
$Company_logo = $_SESSION['Company_logo'];
$Coalition = $_SESSION['Coalition'];

/********************Set Membership ID if Allow_membershipid_once  set to YES*************************/
if(isset($_REQUEST["set_membership_id"]))
{
	$this->session->set_userdata('Set_Membership_id', $_REQUEST["set_membership_id"]);
	$session_data2 = $this->session->userdata('Set_Membership_id');
	
	$this->session->set_userdata('Go_to_back','0');
	$session_data22 = $this->session->userdata('Go_to_back');
}

if(isset($_REQUEST["Reset_membership_id"]))
{
	unset($_SESSION['Set_Membership_id']);

}
/********************************************************************************************/

$data['enroll'] = $session_data['enroll'];	
$data['Sub_seller_Enrollement_id'] = $session_data['Sub_seller_Enrollement_id'];	
$data['Country_id'] = $session_data['Country_id'];	
if($data['Sub_seller_Enrollement_id']!=0)
{
	$Selller_ID=$data['Sub_seller_Enrollement_id'];
}
else
{
	$Selller_ID=$data['enroll'];
}
	
	//$Path=base_url()."index.php/Coal_Transactionc/loyalty_transaction";
	$Path=base_url()."index.php/".$Membership_redirection_url;
	$Reset_Path=base_url()."index.php/Home";

/****************Set Flag for Go_to_back *********************/

$this->session->set_userdata('Go_to_back','1');
$session_data2 = $this->session->userdata('Go_to_back');
// echo "Go_to_back ".$_SESSION["Go_to_back"];
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>iGainSpark</title>
	<link rel="shortcut icon" href="<?php echo base_url()?>images/logo_igain.ico" type="image/x-icon">
    <script src="<?php echo base_url()?>assets/modern_touch/js/libs/modernizr.min.js"></script>
	<script src="<?php echo base_url()?>assets/modern_touch/js/libs/jquery-1.10.0.js"></script>
	<script src="<?php echo base_url()?>assets/modern_touch/js/libs/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="<?php echo base_url()?>assets/modern_touch/style.css" rel="stylesheet" type="text/css" />
	
	<!----------------------Safari form validation----------------------------------------------->
	<script src="<?php echo base_url()?>assets/js/js-webshim/minified/polyfiller.js"></script>
    <script> 
        webshim.activeLang('en');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>
	<!--------------------------------------------------------------------------------------->
</head>

<body>
    <div class="body_wrap">
        <div class="container">

			<!-- content -->
			<div class="content " role="main">
		
				<div  class="col-md-8 col-md-offset-2">
				
					<div class="grid-menu clearfix" style="display:none;" id="error_membership1">					
						<div class="grid-box grid-box-large">
							<div class="alert alert-danger text-center" style="font-weight:bold;">Please Enter Valid Membership ID / Phone No...!!!</div>
						</div>
					</div>
									
                    <!-- Grid Menu -->
                    <div class="grid-menu clearfix">
                        <div class="grid-box grid-box-large">
							<div class="boxed boxed-turquoise" style="padding: 25px;">
							
								<div class="row clearfix">
									<div class="col-md-12">
										<img src="<?php echo base_url().''.$Company_logo; ?>" alt="" class="img-rounded img-responsive" style="margin: 10px auto; width: 40%;">
									</div>
								</div>		
								<br><br>
								<h1 class="text-center">Welcome to our Outlet<?php //echo $Company_name; ?></h1>
								
								<br><br>
								<div class="row">
								
									<div class="col-md-8 col-md-offset-2">
										<form id="searchForm" class="menu-search-form" method="post">
											<input type="text" name="Membership_id" id="Membership_id" required="required" class="menu-search-field" placeholder="Enter Membership ID / Phone No." onkeyup="this.value=this.value.replace(/\D/g,'')" style="font-size: 25px;height: 50px;" />
											<p class="text-danger text-left" style="font-weight: bold;">(*Enter Phone No. without dial Code)</p>
										</form>
									</div>
									<div class="grid-menu clearfix">					
								<div  class="col-md-8 col-md-offset-2" id="Merchant_pin_block" style="display:none;">
									<a href="javascript:void(0);" class="boxed boxed-turquoise" style="padding: 15px;margin-bottom: 0;">
										<div class="row">
											
												
									<input type="password" name="Merchant_pin" id="Merchant_pin_go_back" class="menu-search-field" placeholder="Enter Outlet Pin" style="font-size: 25px;height: 50px;" />
									<span class="text-left" style="font-weight: bold; font-size: 14px;margin-top: 5px;" id="pin_error2"></span>
									<p style="font-size: 19px;font-weight: bold;" class="text-center"><span class="text-danger text-left" style="font-weight: bold; font-size: 14px;float: right;">(*For merchant only)</span></p>
									</div>							
									</a>
								</div>
				</div>
									<div class="col-md-8 col-md-offset-2">
									<!--<?php echo base_url()?>index.php/Home-->
										<div class="col-md-6">
											<a href="javascript:show_merchant_pin_block();" class="btn btn-red btn-icon-left btn-arrow-left" style="padding:19px 0;" >
												<span>Go Back</span>
											</a>
										</div>
										<div class="col-md-6">
											<a onclick="show_cust_details();" href="javascript:void(0);" class="btn btn-red btn-icon-right" style="padding:19px 0;" >
												<span>Proceed</span>
											</a>
										</div>
										
									</div>
								
								</div>
								
							</div>
						</div>
                    </div>
                    <!--/ Grid Menu -->
                </div>
				
			</div>

        </div>
        <!--/ container -->
    </div>
</body>
</html>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="overflow: auto;">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			
			<div class="modal-body">
			
				<div class="row">
					<div class="col-md-6">
						<div class="grid-menu clearfix" style="margin-bottom: 0px;">
							<div class="grid-box grid-box-large">
								<div class="boxed boxed-yellow" style="padding: 30px;margin-bottom: 0;">
									<img src="images/temp/avatar.png" id="Cust_avatar" class="img-responsive img-rounded" style="margin: 0px auto;width:23%;"><br>
									<p style="font-size: 19px;font-weight: bold;" id="Cust_name" class="text-center"></p>
									<p style="font-size: 19px;font-weight: bold;color:blue;" id="Cust_username" class="text-center"></p>
									<input type="hidden" id="Card_id" class="menu-search-field" />
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						
						<div class="col-md-6" style="padding-left: 0px; padding-right: 0px;">
						
							<div class="grid-menu clearfix" style="margin-bottom: 0px;">
								<div class="grid-box grid-box-large">
									<a href="javascript:void(0);" class="boxed boxed-red" style="padding: 7px;">
										<strong><span class="text-center" id="Cust_current_bal"></span></strong>
										<span class="text-center">Current Balance</span>
									</a>
								</div>
							</div>
							
						</div>
						
						<div class="col-md-6" style="padding-left: 0px; padding-right: 0px;"  id="Prepayment_div1">
						
							<div class="grid-menu clearfix" style="margin-bottom: 0px;">
								<div class="grid-box grid-box-large" >
									<a href="javascript:void(0);" class="boxed boxed-red" style="padding: 7px;"  >
										
										<strong><span class="text-center" id="Prepayment_bal" ></span></strong>
										<span class="text-center"  id="Prepayment_div">Prepayment Balance</span>
									</a>
								</div>
							</div>
							
						</div>
						
						<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
						
							<div class="grid-menu clearfix" style="margin-bottom: 0px;">
								<div class="grid-box grid-box-large">
									<a href="javascript:void(0);" class="boxed boxed-red" style="padding: 15px;">
										<!--<strong><span class="glyphicon glyphicon-earphone" aria-hidden="true" style="text-align: center;"></span></strong>-->
										
										<span class="text-center"><img src="<?php echo base_url()."/images/Set_membershipid.png";?>" width="10%"></span>
										<span class="text-center" id="Cust_phnno"></span>
									</a>
								</div>
							</div>
							
						</div>
						
					</div>
				</div>

				<div class="grid-menu clearfix">					
					<div class="grid-box grid-box-large">
						<a href="javascript:void(0);" class="boxed boxed-turquoise" style="padding: 15px;margin-bottom: 0;">
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									
									<input type="password" name="Merchant_pin" id="Merchant_pin" class="menu-search-field" placeholder="Enter Outlet Pin" style="font-size: 25px;height: 50px;" />
									<p style="font-size: 19px;font-weight: bold;" class="text-center"><span class="text-danger text-left" style="font-weight: bold; font-size: 14px;float: right;">(*For merchant only)</span></p>
									<span class="text-left" style="font-weight: bold; font-size: 14px;margin-top: 5px;" id="pin_error"></span>
								</div>
							</div>							
						</a>
					</div>
				</div>
				
				<div class="grid-menu clearfix" style="display:none;" id="error_membership2">		
					<div class="grid-box grid-box-large">
						<div class="alert alert-danger text-center" style="font-weight:bold;">Please Enter Valid Membership ID / Phone No...!!!</div>
					</div>
				</div>
				
			</div>
			
			<div class="modal-footer">
				<a href="javascript:void(0);" class="btn btn-blue  btn-icon-left btn-arrow-left" data-dismiss="modal" id="close_modal">
					<span>Cancel</span>
				</a>
				
				<a href="javascript:void(0);" onclick="store_membershipID();" class="btn btn-red  btn-icon-right" data-dismiss="modal">
					<span>Proceed</span>
				</a>
				
				
			</div>
		</div>

	</div>
</div>

<script>
function show_cust_details()
{
	//alert("In function");
	var set_membershipid = $("#Membership_id").val();
	if(set_membershipid != "")
	{
		var Company_id = '<?php echo $Company_id; ?>';
		var Seller_id = '<?php echo $Selller_ID; ?>';		
		var Sub_seller_Enrollement_id = '<?php echo $data['Sub_seller_Enrollement_id']; ?>';		
		var Country_id = '<?php echo $data['Country_id']; ?>';
		
		//alert("Company_id"+Company_id+"  Seller_id"+Seller_id+"  Sub_seller_Enrollement_id"+Sub_seller_Enrollement_id+"  Country_id"+Country_id+"  set_membershipid"+set_membershipid);
		
		$.ajax(
		{
			//alert('Here 1');
			type: "POST",
			data: { cardid:set_membershipid, Company_id:Company_id, Seller_id:Seller_id, Country_id:Country_id},			
			url: "<?php echo base_url()?>index.php/Login/Get_member_info",
			dataType: "json",
			success: function(json)
			{	
				//alert("Here 2");
				var status = json['status'];
				if(status == '1')
				{
					//alert("Here 3");
					$("#error_membership1").hide();
					var Member_info = json['Member_info'];
					
					$("#Cust_avatar").attr("src", Member_info.Photograph);
					
					var Cust_name = Member_info.First_name + " " + Member_info.Middle_name + " " + Member_info.Last_name;
					$("#Cust_name").html(Cust_name);
					
					$("#Cust_username").html(Member_info.User_email_id);
					//$("#Cust_phnno").html(Member_info.Phone_no);
					$("#Cust_phnno").html(Member_info.Card_id);
					$("#Card_id").val(Member_info.Card_id);
					
					$("#Cust_current_bal").html(json['Cust_seller_balance']);
					$("#Prepayment_bal").html(json['Cust_prepayment_balance']+" "+json['Symbol_currency']);
					//$("#Symbol_currency").html(json['Symbol_currency']);
					if(json['Cust_prepayment_balance'] == 0.00 || json['Cust_prepayment_balance'] == 0)
					{
						$("#Prepayment_div1").hide();
						$("#Prepayment_div").hide();
					}
					//
					var HTML1 = "";		var li_items = [];
					var Offers = json['Offers'];
					var date_time = json['date_time'];
					$('#myModal').show();
					$("#myModal").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
					
					//alert(date_time);
					/*var Offer_length = Object.keys(Offers).length;
					
					if(Offer_length > 1)
					{
						$.each(Offers, function(key,value)
						{
							li_items.push('<li class="col-sm-6 price_col">\n\
										<div class="price_item boxed blue">\n\
											<div class="price_col_body">\n\
												<div class="price_body_inner">\n\
													<ul><li><span>'+value['communication_plan']+'</span></li></ul>\n\
												</div>\n\
											</div>\n\
											<div class="price_col_foot">\n\
												<div class="sign_up" style="padding: 10px;">\n\
													<span style="color: #fff;font-size: 14px;font-weight: 400;text-align: left;">'+value['description']+'</span>\n\
												</div>\n\
											</div>\n\
										</div>\n\
									</li>');
						});
						
						$('#Offer_ul').html( li_items.join('') );
					}
					else
					{
						$.each(Offers, function(key,value)
						{
							HTML1 = '<li class="col-sm-12 price_col">\n\
										<div class="price_item boxed blue">\n\
											<div class="price_col_body">\n\
												<div class="price_body_inner">\n\
													<ul><li><span>'+value['communication_plan']+'</span></li></ul>\n\
												</div>\n\
											</div>\n\
											<div class="price_col_foot">\n\
												<div class="sign_up" style="padding: 10px;">\n\
													<span style="color: #fff;font-size: 14px;font-weight: 400;text-align: left;">'+value['description']+'</span>\n\
												</div>\n\
											</div>\n\
										</div>\n\
									</li>';
							
							$('#Offer_ul').html(HTML1);
						});
					}
					*/
					
					
				}
				else
				{
					//alert("Here 4");
					$("#error_membership1").show();
					$("#Membership_id").val("");
				}
			}
		}); 
	}
	else
	{
		$("#error_membership1").show();
		$("#Membership_id").val("");
	}	
}
function show_merchant_pin_block()
{
	var flag=document.getElementById("pin_error2").innerHTML.length;
	if(flag==80)
	{
		
		window.location='<?php echo base_url()?>index.php/Home?Merchant_pin_back';
	}
	document.getElementById("Merchant_pin_block").style.display="";
}
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#myModal').hide();
		$("#myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});

$('#Merchant_pin').blur(function()
{	
	var Merchant_pinno = '<?php echo $Merchant_pinno; ?>';
	var Entered_pin = $('#Merchant_pin').val();
	
	if( (Entered_pin != Merchant_pinno) || (Entered_pin == "") )
	{
		$('#Merchant_pin').val("");
		$( "#pin_error" ).removeClass( "text-success" ).addClass( "text-danger" );
		$( "#pin_error" ).html("<span class='glyphicon glyphicon-remove' style='float: left;'></span>&nbsp;Please Enter Valid Pin Number...!!!");
		
	}
	else
	{
		$( "#pin_error" ).removeClass( "text-danger" ).addClass( "text-success" );
		$( "#pin_error" ).html("<span class='glyphicon glyphicon-ok' style='float: left;'></span>&nbsp;Valid Pin");
		
	}
});

$('#Merchant_pin').blur(function()
{	
	var Merchant_pinno = '<?php echo $Merchant_pinno; ?>';
	var Entered_pin = $('#Merchant_pin').val();
	
	if( (Entered_pin != Merchant_pinno) || (Entered_pin == "") )
	{
		$('#Merchant_pin').val("");
		$( "#pin_error" ).removeClass( "text-success" ).addClass( "text-danger" );
		$( "#pin_error" ).html("<span class='glyphicon glyphicon-remove' style='float: left;'></span>&nbsp;Please Enter Valid Pin Number...!!!");
		
	}
	else
	{
		$( "#pin_error" ).removeClass( "text-danger" ).addClass( "text-success" );
		$( "#pin_error" ).html("<span class='glyphicon glyphicon-ok' style='float: left;'></span>&nbsp;Valid Pin");
	}
});

$('#Merchant_pin_go_back').blur(function()
{	
	var Merchant_pinno = '<?php echo $Merchant_pinno; ?>';
	var Entered_pin = $('#Merchant_pin_go_back').val();
	
	if( (Entered_pin != Merchant_pinno) || (Entered_pin == "") )
	{
		$('#Merchant_pin_go_back').val("");
		$( "#pin_error2" ).removeClass( "text-success" ).addClass( "text-danger" );
		$( "#pin_error2" ).html("<span class='glyphicon glyphicon-remove' style='float: left;'></span>&nbsp;Please Enter Valid Pin Number...!!!");
	}
	else
	{
		$( "#pin_error2" ).removeClass( "text-danger" ).addClass( "text-success" );
		$( "#pin_error2" ).html("<span class='glyphicon glyphicon-ok' style='float: left;'></span>&nbsp;Valid Pin");
		
	}
});

function store_membershipID()
{
	var Merchant_pinno = '<?php echo $Merchant_pinno; ?>';
	var Entered_pin = $('#Merchant_pin').val();
	
	if( (Entered_pin != Merchant_pinno) || (Entered_pin == "") )
	{
		$('#Merchant_pin').val("");
		$( "#pin_error" ).removeClass( "text-success" ).addClass( "text-danger" );
		$( "#pin_error" ).html("<span class='glyphicon glyphicon-remove' style='float: left;'></span>&nbsp;Please Enter Valid Pin Number...!!!");
		
	}
	else
	{
		$( "#pin_error" ).removeClass( "text-danger" ).addClass( "text-success" );
		$( "#pin_error" ).html("<span class='glyphicon glyphicon-ok' style='float: left;'></span>&nbsp;Valid Pin");
		
		var membership_id = $("#Card_id").val();
		if(membership_id != "")
		{
			var url='<?php echo $Path;?>/?set_membership_id='+membership_id+'&Merchant_pin_back';
		//	alert(url);
			window.location=url;
		}
		else
		{
			//has_error("#has-feedback1","#pin_glyphicon2","#pin_help2","Please Enter Valid Membership ID/Phone No...!!!");
			$("#error_membership2").show();
		}
	}	
}
</script>
<style>
h1, h2, h3, h4, h5, h6 {
    color: #fff;
    font-style: italic;
    line-height: 1.2em;
    margin-bottom: 0.8em;
}
</style>