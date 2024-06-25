<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?></title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?> 
</head>
<body>
<form  name="Rsend-pin" method="POST" action="<?php echo base_url()?>index.php/Cust_home/send_pin" enctype="multipart/form-data">	
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
    <div class="container">
		<div class="section-header">          
			<p><a href="<?php echo base_url();?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Resend Pin</p>
		</div>
		<div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">      
				  <div class="pricing-details">
					<ul>
					  <li id="Small_font" class="text-left">
						<strong id="Value_font">
							<input type="text" readonly name="User_email_id" value="<?php echo $Enroll_details->User_email_id; ?>"id="txt">
						</strong>
						</li>
						<li id="Small_font" class="text-left">
							<strong id="Value_font">
								<input type="text" readonly name="Phone_No"  id="txt" value="<?php echo $Enroll_details->Phone_no; ?>">
							</strong> 
						</li>
					  </ul>
				  </div>
					<address>
						<button type="submit" id="button" onclick="javascript:form_submit();">Send Pin</button>
						<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
						<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
					<address>	
				</div>
			</div>
		</div>
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
	
	#icon{
		width: 6%;
		margin-top: 2%;
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
function send_pin()
{
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';				
	$.ajax
	({
		type: "POST",
		data:{Company_id:Company_id,Enrollment_id:Enrollment_id},
		url: "<?php echo base_url()?>index.php/Cust_home/send_pin",
		success: function(data)
		{	
			// location.reload(); 
		}
	});
}
function form_submit()
{
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	// document.Update_profile.submit();
}
</script>