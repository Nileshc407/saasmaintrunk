<html lang="en">
<head>
<title>Filter</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?> 
</head>
  <body>  
<form  name="mystatement" method="POST" action="<?php echo base_url()?>index.php/Cust_home/MyStatementFilterResult" enctype="multipart/form-data" onsubmit="return Apply_filter();">	
  
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
      <div class="container">
        <div class="section-header ">    
			<p><a href="<?php echo base_url();?>index.php/Cust_home/Load_mystatement_APP" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Statement Filter</p>
        </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">    		
              <div class="pricing-details">
                <ul>		
					<li class="text-left">
							
						<strong>
							<input id="datepicker1" name="startDate" class="txt" placeholder="Select From Date"> 
						</strong>
						
						<div class="help-block" style="float: center;"></div>
					</li>
					<li class="text-left">
						
						<strong>
						<input type="text" id="datepicker2" class="txt"  name="endDate" placeholder="Select Till Date">
						</strong>
						<div class="help-block1" style="float: center;"></div>	
					</li>
					<!--<li class="text-left">
						Redemption Report <br />
						<strong style="font-weight:normal;">
						  <span class="radio-item">
							   <input type="radio" id="ritema" name="Redeemption_report" value="1">
							   <label for="ritema">Yes</label>
						  </span>
						  <span class="radio-item">
							   <input type="radio" id="ritemb" name="Redeemption_report" checked value="0">
							   <label for="ritemb">No</label>
						  </span>
						</strong>
					</li>
					<div id="other_report">
					<li class="text-left">
						Merchant Name  <br />
						<select  name="Merchant"  id="Merchant" class="txt">
							<option value="0">All</option>
							<?php 											
							 /*foreach($Seller_details as $seller)
							{
								echo "<option value=".$seller['Enrollement_id'].">".$seller['First_name'].' '.$seller['Last_name']."</option>";
							} */										
							?>
						</select>
					</li>-->
					<li class="text-left">
						
						<select  name="Trans_Type" id="Trans_Type" class="txt">
							<option value="0">All Transactions</option>
							<?php 											
							foreach($TransactionTypes as $Trans)
							{
								if($Trans['Trans_type_id']==1 || $Trans['Trans_type_id']==2 ||$Trans['Trans_type_id']==10 ||$Trans['Trans_type_id']==13 || $Trans['Trans_type_id']==12 || $Trans['Trans_type_id']==8 )
								{
								echo "<option value=".$Trans['Trans_type_id'].">".$Trans['Trans_type']."</option>";
								}
							}										
							?>
						</select>	
					</li>
					</div>
			<?php /*<li class="text-left">
						Report Type <br />
						<select  name="Report_type"  id="Report_type" class="txt">
							<option value="0" >Details</option>
							<option value="1" >Summary</option>
						</select> 
					</li>  */?>
                </ul>
					<button type="submit" id="button">Apply</button>
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
					<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>">
					<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php
	// $Report_type=$_REQUEST['Report_type'];						
	$From_date=date("Y-m-d",strtotime($_REQUEST["startDate"]));
	$To_date=date("Y-m-d",strtotime($_REQUEST["endDate"]));
	// $Merchant=$_REQUEST["Merchant"];
	$Trans_Type=$_REQUEST["Trans_Type"];			
	// $Redeemption_report=$_REQUEST["Redeemption_report"];
	
	$page=(count($Count_Records)/10); 
	// echo "count-->".count($Count_Records);echo "<br>page ".$page;
	
	?>
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
#icon 
{
    width: 4%;
}
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 13px;
		border-bottom: 1px solid #eee;
		color: #7d7c7c;
	}
	.pricing-table .pricing-details span {
		display: inline-block;
		font-size: 13px;
		font-weight: 400;
		color: #000000;
		margin-bottom: 0x;
		margin-left: 0%;
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
	
	
	#datepicker1
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	#datepicker2
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	
	.txt{
		width: 70%;
		margin-left: 11%;
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() 
{
    $( "#datepicker1" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	
	$( "#datepicker2" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	
});
$("#ritema").click(function()
{
	$("#other_report").hide();
});
$("#ritemb").click(function()
{
	$("#other_report").show();
});
function Apply_filter()
{  
	if( $("#datepicker1").val() == "" )
	{
		var msg1 = 'Please Select From Date';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	if( $('#datepicker2').val() == "" )
	{
		var msg2 = 'Please Select Till Date';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg2);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		return false;
	
	}
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	// document.PromoCode.submit();
}
</script>