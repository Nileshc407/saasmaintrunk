<!DOCTYPE html>
<html lang="en">
<head>
<title>Transfer</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}		
?> 
</head>
  <body> 
	<form  name="TransferPoint" method="POST" action="<?php echo base_url()?>index.php/Cust_home/transferpointsApp" enctype="multipart/form-data" onsubmit="return form_submit();">	
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
      <div class="container">
		<div class="section-header">          
			<p><a href="<?=base_url()?>index.php/Cust_home/Transfer_points_menu" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/left.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Transfer With <?php echo $Company_Details->Alise_name; ?> </p>
		</div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">      
              <div class="pricing-details">
                <ul>
                  <li class="text-left">
				  
						<strong id="Value_font">
							<input type="text" name="Membership_id" placeholder="Enter To Membership Id / Phone No." onblur="Get_member();" id="Membership_id" class="txt" autocomplete="off">
						</strong> 
						<span style="color:red; font-size:9px;" >(Enter to membership id/Phone no. without country code)</span><br>
						<div class="help-block" style="float:center;"></div>
				   </li> 
				   <li class="text-left" id="ToMemberDetails" style="display:none;">
						<span id="Small_font"><b>To Member Details</b></span><br>
						<strong>    
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/name.png" id="arrow" style="margin-top: -5px;" width="13">
							<p class="Value_font" id="Member_name" style=" margin-top: -11px;margin-bottom: 1rem;"> </p>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/un-read.png" id="arrow" style="margin-top: -5px;" width="13">
							<p class="Value_font" id="Member_email_id" style=" margin-top: -11px;margin-bottom: 1rem;"> </p>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/phone.png" id="arrow" style="margin-top: -5px;" width="13">
							<p class="Value_font" id="Member_phone" style=" margin-top: -11px;margin-bottom: 1rem;"> </p>
						</strong>
				   </li>
                  <li class="text-left">
					<strong id="Value_font">
						<input type="tel" name="Transfer_Points" placeholder="Enter Transfer <?php echo $Company_Details->Currency_name; ?>" id="Transfer_Points" class="txt" onblur="Check_current_balance(this.value)" onkeyup="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
					</strong>
					<div class="help-block1" style="float:center;"></div>				  
				</li>
              </ul>
              </div>
				<address>
					<button type="submit"  id="button" onclick="javascript:form_submit();"> Submit </button>
				</address> 
				<input type="hidden" readonly id="Member_Enrollement_id" name="Member_Enrollement_id" >
				<input type="hidden" readonly  id="Member_Current_balance" name="Member_Current_balance" >
				<input type="hidden" readonly  id="Member_Membership_id" name="Member_Membership_id" >				 
				<input type="hidden" readonly id="Login_Enrollement_id" name="Login_Enrollement_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
				<input type="hidden" readonly  id="Login_Current_balance" name="Login_Current_balance" value="<?php echo $Enroll_details->Current_balance; ?>">
				<input type="hidden" readonly  id="Company_id" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
				<input type="hidden" readonly  id="Login_Membership_id" name="Login_Membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
            </div>
          </div>
        </div><br>
		<!--
		<div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">      
              <div class="pricing-details">
				<strong align="center" style="color: #7d7c7c;">Member Details</strong>
                <ul>   
					<li class="text-left">
						<span id="Small_font" class="text-left">Member Name  </span>
						<strong id="Value_font">
							<input type="text" name="Member_name"  id="Member_name" class="txt" readonly>
						</strong>
					</li>
					<li class="text-left">
						<span id="Small_font" class="text-left">Email ID  </span>
						<strong id="Value_font">
							<input type="text" name="Member_email_id"  id="Member_email_id" class="txt" readonly>
						</strong> 
					</li>
					<li class="text-left">
						<span id="Small_font" class="text-left">Phone No.  </span>
						<strong id="Value_font">
							<input type="text" name="Member_phone"  id="Member_phone" class="txt" readonly>
						</strong>
					</li>
                  </ul>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
    <!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
    <!-- Loader -->
	<div class="footer">
		<div class="row" id="foot1">
			<div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/home"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/home.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Home</span></a>
			</div>
			<div class="col-xs-3 footer-xs" id="Footer_font">
                <a href="<?php echo base_url()?>index.php/Beneficiary/Load_beneficiary">
                    <div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/buyjoy.png" alt="" class="img-responsive" id="flat">  </div>	
					<span id="foot_txt">Buy with-<?php echo $Company_Details->Alise_name; ?></span>
                </a>
            </div>
            <div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/Redeemption_menu">
				<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/redeem.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Redeem with-<?php echo $Company_Details->Alise_name; ?></span></a>
			</div>
		</div>
	</div>
</form>
<?php $this->load->view('front/header/footer'); ?> 
<style>
	@media (max-width: 480px) and (min-width: 320px)
	.section-header .section-title {
		font-size: 20px;
		line-height: 30px;
	}
	
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 13px;
		border-bottom: 1px solid #eee;
		color: #7d7c7c;
		text-align: center;
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
	
	.custom-form {
  
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
  .form-group {
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
	
	#icon{
		width: 6%;
		margin-top: 2%;
	}
	
	#balance{
		font-size: 13px;
		font-weight: 600;
		color: #ffffff;
		background: #1fa07f;
		width: 76%;
		margin-left: 13%;
		border-radius: 10px;
		padding: 4px;
		font-family: 'Questrial', sans-serif;
	}
	
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		outline: none;
		width: 100%;
		margin-left: 0%;
		
	}
	.txt{
		border-left: none;
		border-left: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		outline: none;
		width: 100%;
		margin-left: 0%;
		
	}
</style>
<script>
function Get_member()
{
	var Login_Enrollement_id = '<?php echo $enroll; ?>';
	var Membership_id = $('#Membership_id').val();
	var Company_id = '<?php echo $Company_id; ?>';	
	if(Membership_id != "" && Company_id != "")
	{
		$.ajax({
			type: "POST",			 
			data: {Membership_id: Membership_id, Company_id:Company_id, Login_Enrollement_id:Login_Enrollement_id},
			url: "<?php echo base_url()?>index.php/Cust_home/get_member_details",
			success: function(data)
			{
				if(data == 0)
				{
					$('#ToMemberDetails').hide();
					$('#Membership_id').val("");
					$('#Member_name').html("&nbsp;");
					$('#Member_email_id').html("&nbsp;");
					$('#Member_phone').html("&nbsp;");
					
					var msg1 = 'Please Enter Valid Membership Id/Phone no.';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
				else
				{
					var Space = '&nbsp;';
					json = eval("(" + data + ")");
					if( (json[0].Enrollement_id) != 0 )
					{
						$('#ToMemberDetails').show();
						$('#Member_name').html(Space+' '+json[0].First_name+' '+json[0].Last_name);
						$('#Member_email_id').html(Space+' '+json[0].User_email_id);
						$('#Member_phone').html(Space+' '+json[0].Phone_no);
						document.getElementById("Member_Enrollement_id").value=(json[0].Enrollement_id);
						document.getElementById("Member_Current_balance").value=(json[0].Current_balance);
						document.getElementById("Member_Membership_id").value=(json[0].Card_id);
					}
					else 
					{
						$('#ToMemberDetails').hide();
						$('#Membership_id').val("");
						$('#Member_name').html("&nbsp;");
						$('#Member_email_id').html("&nbsp;");
						$('#Member_phone').html("&nbsp;");
					}
				}
			}
		});
	}
	else
	{
		$('#ToMemberDetails').hide();
		$('#Membership_id').val("");
		$('#Member_name').html("&nbsp;");
		$('#Member_email_id').html("&nbsp;");
		$('#Member_phone').html("&nbsp;");
		
		var msg1 = 'Please Enter Valid Membership Id/Phone no.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
}

function Check_current_balance(transPoints)
{
	var login_curr_bal='<?php echo $Current_point_balance; ?>';
	if(parseFloat(transPoints) > parseFloat(login_curr_bal))
	{		
		document.getElementById('Transfer_Points').value='';
		var msg2 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance.';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg2);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		return false;
	}
}
function form_submit()
{
	if($('#Membership_id').val() == "" || $('#Transfer_Points').val() == "")
	{
		if($('#Membership_id').val() == "")
		{
			var msg1 = 'Please Enter Valid Membership Id';
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg1);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
			return false;
		}
		else if($('#Transfer_Points').val() == "")
		{
			var msg1 = 'Please Enter Transfer <?php echo $Company_Details->Currency_name; ?>';
			$('.help-block1').show();
			$('.help-block1').css("color","red");
			$('.help-block1').html(msg1);
			setTimeout(function(){ $('.help-block1').hide(); }, 3000);
			return false;
		}
	}
	else
	{  	
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
	} 		
}
</script>	