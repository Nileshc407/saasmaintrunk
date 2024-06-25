<!DOCTYPE html>
<html lang="en">
<head>
<title>Notification</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
 ?> 
<script>
function Select_delected()
{
		
		var result=1;
		if (result == 1)
		{	
			var urlid = "<?php echo base_url()?>index.php/Cust_home/delete_notification";
			
			var favorite = [];
			var theArray = new Array();
			var i=0;
			$.each($("input[name='note']:checked"), function(){
				
			if(jQuery(this).prop('checked'))
			{
				theArray[i] = jQuery(this).val();
				i++;
			}
			
			});	
			if(theArray !='')
			{	
				setTimeout(function() 
				{
					$('#myModal').modal('show'); 
				}, 0);
				setTimeout(function() 
				{ 
					$('#myModal').modal('hide'); 
				},2000);	
				
				jQuery.ajax({
					 url: '<?php echo base_url()?>index.php/Cust_home/delete_notification',
					 type: 'post',
					 data: {
						 NoteID: theArray,
						 other_id: ''
					 },
					 datatype: 'json',
					 success: function(data)
					 { 
						var msg='Notification Deleted Successfuly.';
						$('.help-block').show();
						$('.help-block').css("color","green");
						$('.help-block').html(msg);
						setTimeout(function(){ $('.help-block').hide(); }, 5000);
						location.reload(); 
					 }
				});
			}
			else
			{
				var msg='Please Select at least anyone Notification.';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').html(msg);
				setTimeout(function(){ $('.help-block').hide(); }, 5000);
				return true;
			}
		}
		else
		{
			return false;
		}	
} 
function Page_refresh()
{
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	// window.location.reload();
}
</script>
</head>
<body> 
<?php $this->load->view('front/header/menu'); ?> 
   <form  name="All_mail_search" method="POST" action="<?php echo base_url()?>index.php/Cust_home/Search_allnotifications" enctype="multipart/form-data">	
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
		<div class="container">
			<div class="section-header">          
				<!--<p><a href="<?php //echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php //echo base_url(); ?>assets/icons/<?php //echo $icon_src; ?>/cross.png" id="arrow"></a></p>-->
				<p id="Extra_large_font" style="margin-left: -3%;">Notification</p>
			</div>
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div id="desc1">											
									<a href="<?php echo base_url();?>index.php/Cust_home/mailbox" ><span id="mail_button" ><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/un-read.png" style="width: 17px"><?php echo $NotificationsCount->Open_notify;?> Un-read </span></a>
									
									<a href="<?php echo base_url();?>index.php/Cust_home/readnotifications"><span id="mail_button" ><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/read.png" style="width: 17px"><?php echo $ReadNotificationsCount->Read_noty;?> Read  </span></a>
									
									<a href="<?php echo base_url();?>index.php/Cust_home/allnotifications" id="active"><span id="mail_button"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/all.png" style="width: 17px"><?php echo $AllNotificationsCount->All_noty;?> All</span></a>
								</div> 
								<div style="width:35%;">												
									<a href="#"><span id="button5" onclick="Select_delected()"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/delete.png" style="width: 20px"> </span></a>
									<a href="<?php echo base_url();?>index.php/Cust_home/allnotifications"><span id="button5" onclick="Page_refresh();"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/refresh.png" style="width: 20px">  </span></a>
								</div>
								<div style="width:55%;">		
									<address>      
									   <input type="text" name="Search_mail" placeholder="Search" id="Search_mail1" class="txt" autocomplete="off">
									   <a href="#">
										<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="search" onclick="form_submit();">
									   </a>
									</address> 
								</div>
							</div>
							<div class="help-block" style="float: center;"></div>
							<hr>
						<?php	
							foreach($AllNotifications as $note)
							{		
								$date1 = date('Y-m-d',strtotime($note['Date']));
								$date2 = date('Y-m-d');
								$diff = abs(strtotime($date2) - strtotime($date1));
								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								if($years=='0')	{ $years=''; }
								else{	$years=$years.' Year-'; }
								if($months=='0'){ $months=''; }
								else{$months=$months.' Months-';}
								if($days=='0'){$days='';}elseif($days==1){$days=$days.' Day';}
								else{$days=$days.' Days';}
							?>
								<div class="row ">
									<div class="col-xs-2" style="width: 10%;">
										<input type="checkbox" name='note' value="<?php echo $note['Id']; ?>">
									</div>
									<div class="col-xs-6 text-left" style="width: 40%;">
										<span id="Value_font">
											<a id="mail_body" style="text-decoration: none" href="<?php echo base_url();?>index.php/Cust_home/compose?Id=<?php echo $note['Id']; ?>"></a>
										
											<a id="mail_body" style="text-decoration: none" href="<?php echo base_url();?>index.php/Cust_home/compose?Id=<?php echo $note['Id']; ?>"><?php echo $note['Offer']; ?></a>
										</span>
									</div>
									<div class="col-xs-6" style="width: 40%;">
										<span id="Small_font">
										<?php 
										  if( $years=="" && $months =="" &&  $days== "")
										  {
											echo 'Some time before';
										  }
										  else
										  {
											 echo $years, $months, $days.' ago';
										  }
										?>
										  </span>
									</div>
								</div><hr>		
						<?php 
							}
						?>
						</div>
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
<script>
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

    document.All_mail_search.submit();
} 
</script>
<style>

	#mail_body
	{
		color:<?php echo $Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?php echo $Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?php echo $Value_font_details[0]['Value_font_size']; ?>;
	}
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}
	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{font-size: 13px;}
	
	
	.btn 
	{
		color: #1fa07f;
		border-color: #1fa07f;
		background-color: #fff;
		padding: 7px;
		font-size: 12px;
		font-weight: bold;
		border-radius: 15px;
	}
	
	.card-span {

		color: #1fa07f !important;
		font-size: 12px !important;
		display: inline;
	}
	
	.main-xs-3
	{
		width: 27%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 45%;
		padding: 10px 10px 0 10px;
	}
	
	.X{
		color:#1fa07f;
	}
	

	
	
	
	 #button5{
		
		padding: 0 2%;
		border-radius: 2px;
		margin: 15% 3%;
		color:#1fa07f;
	}
	#mail_button
	{
		color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
		font-family:<?php echo $Button_font_details[0]['Button_font_family'];?>;
		font-size:<?php echo $Button_font_details[0]['Button_font_size'];?>;
		background:<?php echo $Button_font_details[0]['Button_background_color'];?>;
		border-radius:7px;
		margin:0px;
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
		padding: 5px;
	
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
	}
	
	#icon{
		font-size:17px;
	}
	
	#text5{
		font-size:11px;
	}
	
	/* Carousel Css Started */
	.carousel-indicators li {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: #ffffff;
		border: 1px solid #1fa07f;
	}
	
	.carousel-indicators {
		position: absolute;
		bottom: 10px;
		left: 50%;
		z-index: 15;
		width: 60%;
		padding-left: 0;
		margin: 17% 2px -2% -30%;
		text-align: center;
		list-style: none;
	}
	
	#smbtn{
		margin: 2%;
	}
	/* Carousel Css Ended */
	
	#desc1{
		width:99%;
	}
	
	#desc2{		
		color: #7d7c7c;
		margin-bottom: 4%; 
		font-size: 12px;
	}
	
	#img{
		width:69%;
		margin-left: 16%;
	}
	.carousel-indicators .active {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: #1fa07f;
	}

	
	#sm{
		padding:2%;
	}
	
	#active{
		padding: 5% 0px 3% 0px; 
		border-bottom: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
	}
/*Serach box*/

.txt{
  border: none;
  padding: 1% 0 0 0;
  width:56%;
  outline: none;
  background: none;
  margin-left: 16%;
  height: 29px;
 }
 
 #search{
  font-size:20px;
  margin-left: 5%;
  color: #ffffff;
  width: 11%;  
 }
 <?php /*
 ::placeholder {
 color: #ffffff;
 }
 */ ?>
 address{
  border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
  padding: 0;
  border-radius: 50px;
  margin: 7% 1%;
 }
/*Serach box*/
</style>