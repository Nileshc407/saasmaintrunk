<!DOCTYPE html>
<html lang="en">
<head>
<title>Gift Cards</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }

?>
</head>
<body>
    
     <?php 
        $item_count=0;
        if($Redeemtion_details2 != NULL) {
            foreach($Redeemtion_details2 as $item)
            {

                $item_count=$item_count+$item["Total_points"]; 
            }
        }
        if($item_count <= 0 ) {
                $item_count=0;
        }
        else {
                $item_count = $item_count;
        }
		// $Curr_balance=$Enroll_details->Current_balance-$Enroll_details->Blocked_points;
		
		$Curr_balance=$Enroll_details->Total_balance;  
		
		$Current_point_balance = ($Curr_balance-$Enroll_details->Debit_points);
				
		if($Current_point_balance<0)
		{
		 $Current_point_balance=0;
		}
		else
		{
			$Current_point_balance=$Current_point_balance;
		}
	   
    ?> 
	<form  name="Search_giftcards" method="POST" action="<?php echo base_url()?>index.php/Redemption_Catalogue/Search_giftcards" enctype="multipart/form-data">	
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container" >
            <div class="section-header">          
                <p><a href="<?php echo base_url()?>index.php/Cust_home/Redeemption_menu" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Gift Cards</p>
            </div>	
			
            <div class="row pricing-tables">                
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
						</div>
					</div>					  
                </div>
                <!-- Loader -->	
                                
				<div class="sticky-container">
					<ul class="sticky">
						<li> 
						
						<img width="32" height="32" id="cur_bal_left" alt="" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" />
						<img id="cur_bal_right" style="display:none" alt="" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/right.png" />
						
							<p id="home_menu"><font style="font-size:11px">Wallet Balance</font><br><font style="font-size:16px"><?php echo $Current_point_balance; ?></font> <font style="font-size:11px"><?php echo $Company_Details->Currency_name; ?> </font></p>
						</li>
					</ul>
				</div>                        
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
  
					<address style="margin-left:12px; margin-bottom:15px; margin-top: 4px"> 
						<a href="<?php echo base_url(); ?>index.php/Redemption_Catalogue/Gift_cards"><span id="button5" onclick="Page_refresh();"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/refresh.png" style="width: 20px"></span></a>						
					   <input type="text" name="Search_key" placeholder="Search" id="Search_mail" autocomplete="off">
					   <a href="#">
						<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="search" onclick="form_submit();">
					   </a>
					</address> 
					
                    <?php
                    
                    if($Redemption_Items != NULL)
                    {
                        foreach ($Redemption_Items as $product)
						{

							$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];
							foreach ($Branches as $Branches2) {
								$DBranch_code=$Branches2['Branch_code'];
							}
							?>
							<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">
							<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
							<div class="pricing-details">
								<div class="row">
									<div class="col-md-12">
										<div class="row "> <?php /*
											<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo $product['Company_merchandise_item_id']; ?>"> */ ?>
												<div class="col-xs-4" style="padding: 10px;">
														<img src="<?php echo $product['Thumbnail_image1']; ?>" alt="" class="img-rounded img-responsive" width="80" height="60">
												</div>
										<!--	</a>-->       
												<div class="col-xs-8 text-left" style="width: 66%;"><?php /*
													<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo $product['Company_merchandise_item_id']; ?>"> */ ?>
														<address>
																<strong id="Medium_font"><?php echo $product['Merchandize_item_name']; ?></strong><br>
														</address>
													 
													<?php  
														if($product['Size_flag'] == 1) 
														{ 
																												$Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
																														$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
																																												$points= $Get_item_price->Billing_price_in_points;
																																												$Item_size=$Get_item_price->Item_size;
														} 
														else 
														{
                                                                                                                    $Item_size="0";
                                                                                                                    $Billing_price_in_points = $product['Billing_price_in_points'];
                                                                                                                    $points= $product['Billing_price_in_points'];
														}
													?>
													<span style="color: #ff3399;margin-bottom: 0; font-size: 12px;"><strong id="Value_font"><?php echo $points;?> <?php echo $Company_Details->Currency_name; ?> </strong></span>
												</div>
								<!--		 </a> -->
										</div>
										<div class="row">                                                
											<?php  if($product['Delivery_method']==0){ ?>
                                                                                    
                                                                                   
												<?php /* ?>	
												<div class="col-xs-3 main-xs-3">
													<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" style="margin:-3%;">
													<span>
															<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/pick-up.png" id="arrow" width="20">
															<br><span id="Small_font">&nbsp;Pickup</span>
													</span>                                                            
													<div style="display:none;" id="<?php echo $product['Company_merchandise_item_id']; ?>" style="margin-bottom: 6%;">
														<select name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" class="txt" style="height:30px;margin-bottom: 6%;width: 260px;margin-left: 13%;">
															<option value=""><?php echo ('Select Pickup Location'); ?></option>
															<?php foreach ($Branches as $Branches3){?>
															<option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
															<?php } ?>
														</select>
													</div> 
												</div>
												<div class="col-xs-3 main-xs-3">
														<input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked style="margin:-3%;">
														<span>
															<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/delivery.png" id="arrow" width="20">
															<br><span id="Small_font">&nbsp;Delivery</span>
														</span>
												</div>  
											<?php */ ?>
											<div class="col-xs-3 main-xs-3">
												 <?php foreach ($Branches as $Branches3){
													$Branch_code=$Branches3['Branch_code'];
													$Branch_name= $Branches3['Branch_name']; 
												 } ?>
												<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $Branch_code; ?>" style="margin:-3%;" checked>
												<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" checked style="margin:-3%; display: none;">
											</div>
											<div class="col-xs-3 main-xs-3"></div>
												<div class="col-xs-6 text-right main-xs-6">
													<!--<span id="button" class="b-items__item__add-to-cart">Add to cart</span>-->
													<button type="button" id="button"  onclick="add_to_cart('<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Delivery_method']; ?>',location_<?php echo $product['Company_merchandise_item_id']; ?>.value,'<?php echo $product['Merchandize_item_name']; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $product['Company_merchandise_item_id']; ?>,<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>);" style="margin-left: -6px; margin-bottom: 10px;">
															<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/redeem.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Add to Cart
													</button>
													<br>
													
												</div>
												<div id="alert_div_<?php echo $product['Company_merchandise_item_id']; ?>" style="float: right;margin: 0 auto;"></div>
											<?php } elseif($product['Delivery_method']==28) { ?>
                                                                                               
												<?php /* ?>
												<div class="col-xs-6 main-xs-6">
													<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" style="margin:-3%;" checked>
													<span>
														<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/pick-up.png" id="arrow" width="20">
														<br><span id="Small_font">&nbsp;Pickup</span>
													</span>

												   
													<select name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" class="txt" style="height:30px;margin-bottom: 6%;width: 260px;margin-left: 13%;">
														
														<option value=""><?php echo ('Select Pickup Location'); ?></option>
														<?php foreach ($Branches as $Branches3){?>
														<option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
														<?php } ?>
													</select>
												</div>
                                      <?php */ ?>
                                        <div class="col-xs-6 main-xs-6">
										<?php foreach ($Branches as $Branches3){
											$Branch_code=$Branches3['Branch_code'];
											$Branch_name= $Branches3['Branch_name']; 
										 } ?>
										<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28"  style="margin:-3%; display: none" checked>
									   
										<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $Branch_code; ?>" style="margin:-3%;" checked>
									   
									</div>
									<div class="col-xs-6 text-right main-xs-6" style="margin-left:28px;">
										<!--<span id="button" class="b-items__item__add-to-cart"> Add to cart</span>-->
										<button type="button" id="button"  onclick="add_to_cart('<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Delivery_method']; ?>',location_<?php echo $product['Company_merchandise_item_id']; ?>.value,'<?php echo $product['Merchandize_item_name']; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $product['Company_merchandise_item_id']; ?>,<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>);" style="margin-left: -6px; margin-bottom: 10px;">
									  <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/redeem.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Add to Cart
										</button>
										 <br>
										
									</div>
									<div id="alert_div_<?php echo $product['Company_merchandise_item_id']; ?>" style="float: right;margin: 0 auto;"></div>
								<?php } else { ?>
                                                                                                     
					<?php /* ?>
					<div class="col-xs-6 main-xs-6">
						<input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked style="margin:-3%;">
						<span>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/delivery.png" id="arrow" width="20">
							<br><span id="Small_font">&nbsp;Delivery</span>
						</span>
					</div> 
					<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="0">
					
					<?php */ ?>
          <?php foreach ($Branches as $Branches3){
					$Branch_code=$Branches3['Branch_code'];
					$Branch_name= $Branches3['Branch_name']; 
				} ?>
                <div class="col-xs-6 main-xs-6">
                                                                                                        
                <input type="radio" value="28"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" checked style="margin:-3%;display: none;">
                <input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo  $Branch_code; ?>">
               </div>
                                                                                                
				<div class="col-xs-6 text-right main-xs-6" style="margin-left:28px;">
					<!--<span id="button" class="b-items__item__add-to-cart">Add to cart</span> -->
					<button type="button" id="button" onclick="add_to_cart('<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Delivery_method']; ?>',location_<?php echo $product['Company_merchandise_item_id']; ?>.value,'<?php echo $product['Merchandize_item_name']; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $product['Company_merchandise_item_id']; ?>,<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>);" style="margin-left: -6px; margin-bottom: 10px;">
																																		<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/redeem.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Add to Cart
					</button>
					<br>
														
				</div>
				<br>
				<div id="alert_div_<?php echo $product['Company_merchandise_item_id']; ?>" style="float: right;margin: 0 auto;"></div>
											<?php } ?>
												
										</div>

										
									</div>
								</div>
							</div>
						</div>
						<br>
						<?php
						}
                    }
                    else
                    {
                        ?>
                        <div class="pricing-table wow fadeInUp animated" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head" style="visibility: visible;-webkit-animation-duration: 1000ms; -moz-animation-duration: 1000ms; animation-duration: 1000ms;-webkit-animation-delay: 0.3s; -moz-animation-delay: 0.3s; animation-delay: 0.3s;">
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">
                                            <div class="row ">                                                      
                                                    <div class="col-xs-8 text-left" style="width: 100%;">
                                                        <address align="center">
                                                            <strong id="Medium_font">No Item Found</strong><br>
                                                            
                                                        </address>                                                        
                                                    </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>	
                </div>
            </div>
        </div>
    </div>
</form>
    
<?php $this->load->view('front/header/footer');?>    
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

		document.Search_giftcards.submit();
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
	
    function Show_branch(Company_merchandise_item_id,flag)
    {
        if(flag==1)
        {
            document.getElementById(Company_merchandise_item_id).style.display="";
        }
        else
        {
            document.getElementById(Company_merchandise_item_id).style.display="none";
        }
    }
        
    function add_to_cart(Company_merchandize_item_code,Delivery_method,location,Merchandize_item_name,Points,Item_size,Company_merchandise_item_id,Item_Weight,Weight_unit_id)
    {           
        var Checked_Delivery_method = $("input[name=Delivery_method_"+Company_merchandise_item_id+"]:checked").val();
        if(Checked_Delivery_method==29)
        {
            location=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
        } 
        if(location=="" && Checked_Delivery_method==28)//Pick up
        {
            var msg1 = 'Please Select Pickup Location';
            $('#alert_div_'+Company_merchandise_item_id).show();
            $('#alert_div_'+Company_merchandise_item_id).css("color","red");
            $('#alert_div_'+Company_merchandise_item_id).html(msg1);
            setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
           // $('#alert_div_'+Company_merchandise_item_id).focus();
            return false;
        }
        else
        {

			// var Total_balance = <?php echo $Enroll_details->Total_balance;?>;
			var Total_balance = '<?php echo $Current_point_balance;?>';
		   // var Current_redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
			// var Current_redeem_points=$('#cart_count').val();
			var Current_redeem_points='<?php echo $item_count; ?>';
			Current_redeem_points=(parseInt(Current_redeem_points)+parseInt(Points));
			if(Current_redeem_points > Total_balance)
			{
				// ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
				//alert('Insufficient Current Balance');
				var msg1 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance';
				$('#alert_div_'+Company_merchandise_item_id).show();
				$('#alert_div_'+Company_merchandise_item_id).css("color","red");
				$('#alert_div_'+Company_merchandise_item_id).html(msg1);
				setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); },3000);
				return false;
			}
			else
			{	
				setTimeout(function() 
				{
				$('#myModal').modal('show');

					$.ajax({
					type: "POST",
					data: { Company_merchandize_item_code:Company_merchandize_item_code, Delivery_method:Checked_Delivery_method, location:location, Points:Points,Current_redeem_points:Current_redeem_points,Total_balance:Total_balance,Size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id },
					url: "<?php echo base_url()?>index.php/Redemption_Catalogue/add_to_cart",
					success: function(data)
					{

						// alert(data.cart_success_flag);		
						if(data.cart_success_flag == 1)
						{
							if(parseInt(data.cart_total)>Total_balance)
							{

								var msg1 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance';
								$('#alert_div_'+Company_merchandise_item_id).show();
								$('#alert_div_'+Company_merchandise_item_id).css("color","red");
								$('#alert_div_'+Company_merchandise_item_id).html(msg1);
								setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); },3000);
								return false;
							}
							else
							{

								var url= "<?php echo base_url(); ?>index.php/Redemption_Catalogue/Redemption_Catalogue";
								var msg1 = 'Item added to Cart Successfully';
								$('#alert_div_'+Company_merchandise_item_id).show();
								$('#alert_div_'+Company_merchandise_item_id).css("color","green");
								$('#alert_div_'+Company_merchandise_item_id).html(msg1);
								setTimeout(function(){

								$('#alert_div_'+Company_merchandise_item_id).hide(); 
									// window.top.location.reload();
									window.location.href = "<?php echo base_url(); ?>index.php/Redemption_Catalogue/Gift_cards";
								},4000);
							}
						}
						else
						{

							var msg1 = 'Error adding Item to Cart';
							$('#alert_div_'+Company_merchandise_item_id).show();
							$('#alert_div_'+Company_merchandise_item_id).css("color","red");
							$('#alert_div_'+Company_merchandise_item_id).html(msg1);
							setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); },3000);
						}
					}
				});
				
				 }, 0);
				setTimeout(function() 
				{ 
					$('#myModal').modal('hide');	
				},3000);
			}              
        }	
    }
$(document).ready(function() {
    $('#cur_bal_left').click(function(e) 
	{     
		$("#cur_bal_left").hide();
		$("#cur_bal_right").show();
		$(".sticky li").css("margin-left","-105px");
    });
	$('#cur_bal_right').click(function(e) 
	{   
		$("#cur_bal_left").show();
		$("#cur_bal_right").hide();
		
		$(".sticky li").css("margin-left","0");
    });
});
</script>
<style>
	
    #cur_bal_right, #cur_bal_left
	{    width: 14%;
	}

    input[type='radio']:after {
       content: " ";
    display: inline-block;
    position: relative;
   
    margin: 0 5px 4px 0;
    width: 13px;
    height: 13px;
    border-radius: 11px;
    border: 1.8px solid #ef888e;
    background-color: white;
    }

    input[type='radio']:checked:after {
       
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #ef888e;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;   
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
		
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
	}	
	.main-xs-3
	{
		width: 27%;
		padding: 0 0 0 10px;
	}	
	.main-xs-6
	{
		width: 45%;
		padding: 10px 10px 0 10px;
	}	
	
	.action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
		margin-left: -10%;
	}
	
	/* Search Bar Css */
	#txt{
		border: none;
		padding: 1% 0 0 0;
		width:56%;
		outline: none;
		background: none;
		margin-left: 16%;
		color: #ffffff;
		height: 35px;
	}
	
	#search{
		font-size:20px;
		margin-left: 2%;	
	}	
	address{
		
		padding: 0;
		border-radius: 50px;
		margin:4% 0%;
		
	}
	/* Search Bar Css Ended*/
	
	
	
	#text5{
		font-size:11px;
	}
	
	
        @media screen and (min-width: 320px) {
            #cart_count {
			<?php if(strlen($item_count) == 1 || strlen($item_count) == 2 ) { ?>
					width: 7%;
			<?php } elseif(strlen($item_count) == 3 ){ ?>
					width: 9%;
			<?php } elseif(strlen($item_count) == 4 ){  ?> 
					width: 11%;
			 <?php } elseif(strlen($item_count) == 5 ){ ?> 
					width: 13%; 
			 <?php } elseif(strlen($item_count) == 6 ){ ?> 
					width: 15%; 
			<?php } ?>
				width: 20%; 
				margin-left:-10%;
                height: 30px;
                text-align: center;
                border: none;
                position: absolute;
                font-size: 11px;
                padding: 0px;
                line-height: .9;
                background: red;
                color: white;
                border-radius: 5%;
            }
        }
        @media screen and (min-width: 768px) {
            #cart_count {
               <?php if(strlen($item_count) == 1 || strlen($item_count) == 2 ) { ?>
					width: 7%;
			<?php } elseif(strlen($item_count) == 3 ){ ?>
					width: 9%;
			<?php } elseif(strlen($item_count) == 4 ){  ?> 
					width: 6%;
			 <?php } elseif(strlen($item_count) == 5 ){ ?> 
					width: 6%; 
			 <?php } elseif(strlen($item_count) == 6 ){ ?> 
					width: 6%; 
			<?php } ?>
			
                margin-left:-9%;
                height: 30px;
                text-align: center;
                border: none;
                position: absolute;
                font-size: 11px;
                padding: 0px;
                line-height: .9;
                background: red;
                color: white;
                border-radius: 5%;
            }
        }
        
        
        
         .txt {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    border-left-color: -moz-use-text-color;
    border-left-style: none;
    border-left-width: medium;
    border-top-color: -moz-use-text-color;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-top-style: none;
    border-top-width: medium;
    margin-left: 0;
    outline-color: -moz-use-text-color;
    outline-style: none;
    outline-width: medium;
    padding-bottom: 2%;
    padding-left: 1%;
    padding-right: 1%;
    padding-top: 4%;
    width: 100%;
}



.sticky-container {

padding: 0px;
margin: 0px;
position: fixed;
right: -127px;
top: 130px;
width: 157px;
z-index:9999;
}
.sticky li {
list-style-type: none;
<?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) { ?>
        background-image: url("<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'application', 'value',$Company_id); ?>");
        background-repeat: no-repeat;
        background-size: cover;
<?php  } else { ?>

         background:<?php echo $General_details[0]['Theme_color']; ?>;
<?php  }    ?>;

color: #efefef;

padding: 0px;
margin: 100px 0px 1px 0px;
-webkit-transition: all 0.25s ease-in-out;
-moz-transition: all 0.25s ease-in-out;
-o-transition: all 0.25s ease-in-out;
transition: all 0.25s ease-in-out;
cursor: pointer;
filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
filter: gray;

}
.sticky li:hover {
	
margin-left: -75px;
}
.sticky li img {
float: left;
margin: 5px 5px;
margin-right: 3px;
}
.sticky li p {

margin: 0px;

}
li>p{
	line-height: 22px;

}
#button5{
	
	padding: 0 2%;
	border-radius: 2px;
	margin: 15% 3%;
	color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
}
</style>