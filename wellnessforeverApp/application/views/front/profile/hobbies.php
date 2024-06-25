<!DOCTYPE html>
<html lang="en">
  <head>
   <title>Hobbies</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }   
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
  </head>
<body>
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
		<div class="container" >
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Hobbies</p>
			</div>
			
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">			
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
									<?php	
										$Hobbie_array= array();
										foreach($Hobbies_interest as $hobbies) 
										{ 
												$Hobbie_array[]=$hobbies['Hobbie_id'];
										} 

										// print_r($Hobbie_array);
										foreach($All_hobbies as $alhobe)
										{
											if($alhobe['Id']==1)
											{
													$img_icon='fashion.png';
											}
											else if($alhobe['Id']==2)
											{
													$img_icon='travel.png';
											}
											else if($alhobe['Id']==3)
											{
													$img_icon='game.png';
											}
											else if($alhobe['Id']==4)
											{
													$img_icon='reading.png';
											}
											else if($alhobe['Id']==5)
											{
													$img_icon='music.png';
											}
											else if($alhobe['Id']==6)
											{
													$img_icon='cook.png';
											}
											else if($alhobe['Id']==7)
											{
													$img_icon='drama.png';
											}
											else if($alhobe['Id']==8)
											{
													$img_icon='gadget.png';
											}
											else if($alhobe['Id']==9)
											{
													$img_icon='food.png';
											}
											else if($alhobe['Id']==10)
											{
													$img_icon='fitness.png';
											}
											else if($alhobe['Id']==11)
											{
													$img_icon='sport.png';
											}
											else if($alhobe['Id']==12)
											{
													$img_icon='art.png';
											}
											else 
											{
													$img_icon='adventure.png';
											}

											if(in_array( $alhobe['Id'],$Hobbie_array)) 
											{
											?>	
												<div class="col-xs-4 text-right main-xs-6">
													<input name="hobbies" type="checkbox" class="roundedTwo" id="chk_<?php echo $alhobe['Id']; ?>" value="<?php echo $alhobe['Id']; ?>" checked >
													<label id="Small_font">

													 <img  src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/<?php echo $img_icon;?>" id="<?php echo $alhobe['Id']; ?>" alt="<?php echo $alhobe['Hobbies']; ?>"  width="65" onclick="getchecked(<?php echo $alhobe['Id']; ?>)">
												   <br/> <?php echo $alhobe['Hobbies']; ?> </label>											
												</div>	
											<?php
											}
											else
											{
											?>	
												<div class="col-xs-4 text-right main-xs-6">
													<input name="hobbies" type="checkbox" id="chk_<?php echo $alhobe['Id']; ?>"  value="<?php echo $alhobe['Id']; ?>"  >
													<label id="Small_font">

													 <img  src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/<?php echo $img_icon;?>" id="<?php echo $alhobe['Id']; ?>" alt="<?php echo $alhobe['Hobbies']; ?>"  width="65" onclick="getchecked(<?php echo $alhobe['Id']; ?>)"> 
													 <br/><?php echo $alhobe['Hobbies']; ?></label>
												</div>
											<hr>
											<?php
											}	
										}
										?>																		
									</div>
										<div class="help-block1" style="float: center;"></div>
                                       <div class="help-block2" style="float: center;"></div>
									   
									<address>
										<button type="submit"  onclick="Change_hobbies();" id="button">Submit</button>
										<button type="submit" onclick="window.location.href='<?php echo base_url(); ?>/index.php/Cust_home/profile'" id="button">Close</button>
									</address>
									
								</div>
							</div>
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
	
	
<?php $this->load->view('front/header/footer'); ?> 
<style>
  
	.main-xs-3
	{
		width: 27%;
		padding: 0 0 0 10px;
	}
	
	.main-xs-6
	{
		width: 50%;
		padding: 10px 10px 0 10px;
	} 

	
	
	:checked+label:before {
	  content: url("<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/checked_checkbox.png");
	}
	input[type=checkbox] {
	  display: none;
	}

	label {
		display: inline-block;
		margin-bottom: .5rem;
		text-align: center;
	}
	@media screen and (min-width: 320px) 
	{
	.main-xs-6 {
    width: 50%;
    padding: 10px 25px 0 10px;
	}	
	@media screen and (min-width: 768px) 
	{
	.main-xs-6 {
    width: 50%;
    padding: 10px 110px 0 10px;
	}	
	
}
</style>
<script>
	$('img').click(function(){
		$('.selected').removeClass('selected');
		$(this).addClass('selected');
	});

	function getchecked(imdID)
	{
		if(document.getElementById('chk_'+imdID).checked== true)
		{
			document.getElementById('chk_'+imdID).checked=false;
		}
		else
		{
			document.getElementById('chk_'+imdID).checked = true; 
		}   
	}
	function Change_hobbies()
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
		var checkValues = $('input[name=hobbies]:checked').map(function()
		{
			return $(this).val();
			
		}).get();

		if(checkValues == null || checkValues==0)
		{
			// $("#feedback55").show();
			var msg='Please Select at least anyone hobbie';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg);
			setTimeout(function(){ $('.help-block2').hide(); }, 2000);
			return false;
		}
		
		  
		$.ajax({
			url : "<?php echo base_url()?>index.php/Cust_home/update_hobbies",
			type: 'post',
		   data:{ Company_id:Company_id,Enrollment_id:Enrollment_id,new_hobbies:checkValues},
			success:function(data)
			{
			
				if(data == 1) 
				{
					var msg='Hobbies Upadated Successfully!!';
			
					$('.help-block1').show();
					$('.help-block1').css("color","green");
					$('.help-block1').html(msg);
					setTimeout(function(){ $('.help-block1').hide(); }, 10000);
				
					location.reload();
				}
				else
				{
					var msg='Hobbies Upadated Un-successfully !!';
			
					$('.help-block1').show();
					$('.help-block1').css("color","red");
					$('.help-block1').html(msg);
					setTimeout(function(){ $('.help-block1').hide(); }, 10000);
				}
			}
		});
	}
</script>