<!DOCTYPE html>
<html lang="en">
<head>
<title>Review Redemption</title>	
<?php $this->load->view('front/header/header');
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
 ?> 
</head>
<body>   
   <?php 
        $item_count=0;
        if($Redemption_Items != "") {
            foreach($Redemption_Items as $item)
            {
                $item_count=$item_count+$item["Total_points"]; 
                if($item["Redemption_method"]==29)
		{
			$Delivery_method=1;
		}
            }
        }
        if($item_count <= 0 ) {
                $item_count=0;
        }
        else {
                $item_count = $item_count;
        }        
    ?> 
	<?php  echo form_open('Redemption_Catalogue/Insert_Redeem_Items'); ?>
        <div id="application_theme" class="section pricing-section" style="min-height:520px;">
            <div class="container">
                <div class="section-header">          
                        <p><a href="<?php echo base_url(); ?>index.php/Redemption_Catalogue/Get_Shipping_details" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                        <p id="Extra_large_font">Review Redemption</p>
                </div>
                <div class="row pricing-tables">			
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
                        <!-- Main Card -->
        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
                        <?php if(!empty($Redemption_Items)) { ?>	<!-- 1 card -->
                       <?php 
                            $Exist_Delivery_method=0;
                            $Sub_total2=0;
                            foreach ($Redemption_Items as $item2) {									
                                    $Sub_total2=$Sub_total2+$item2["Total_points"];
                            }
                            foreach ($Redemption_Items as $item) {
                                
                                $Get_Code_decode = $this->Igain_model->Get_codedecode_row($item["Redemption_method"]);	
                                $Redemption_method=$Get_Code_decode->Code_decode;
                                if($item["Redemption_method"]==29)
                                {
                                        $Exist_Delivery_method=1;
                                        $Get_weight_items = $this->Redemption_Model->get_weight_items_same_location($item["Partner_state"],$enroll);
                                        $Weight_in_KG=0;
                                        foreach($Get_weight_items as $rec)
                                        {
                                                $Total_weight_same_location=$rec["Total_weight_same_location"];
                                                $lv_Weight_unit_id=$rec["Weight_unit_id"];
                                                /*******Total Weight convert into KG for same location****/
                                                $kg=1;
                                                switch ($lv_Weight_unit_id)
                                                {
                                                        case 2://gram
                                                        $kg=0.001;break;
                                                        case 3://pound
                                                        $kg=0.45359237;break;
                                                }
                                                $Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
                                                // echo "<br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id;
                                        }
                                        /*******Single Weight convert into KG****/

                                        $kg2=1;
                                        switch ($item["Weight_unit_id"])
                                        {
                                                case 2://gram
                                                $kg2=0.001;break;
                                                case 3://pound
                                                $kg2=0.45359237;break;
                                        }

                                        /**************************/


                                        $Single_Item_Weight_in_KG=($item["Weight"]*$item["Quantity"]*$kg2);

                                         // echo "<br><br><b>Merchandize_item_name </b>".$item["Merchandize_item_name"]." <br><b>Weight </b>".$item["Weight"]." <br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG." Quantity </b>".$item["Quantity"]." <br><b>Weight_unit_id </b>".$item["Weight_unit_id"]." <br><b>Weight_in_KG </b>".$Weight_in_KG." <br><b>Partner_state</b> ".$item["Partner_state"]." <br><b>Temp_cart_id </b>".$item["Temp_cart_id"];
                                }
                                else
                                {
                                        $Total_Weighted_avg_shipping_pts[]=0;
                                        $Weighted_avg_shipping_pts="-";
                                }
                                if($Shipping_charges_flag==2)
                                {
                                        if($item["Redemption_method"]==29)
                                        {
                                            $Get_shipping_points = $this->Igain_model->Get_delivery_price_master($item["Partner_Country_id"],$item["Partner_state"],$To_Country,$To_State,$Weight_in_KG,1);
                                            $Shipping_cost= $Get_shipping_points->Delivery_price;
                                            $Shipping_pts=round($Shipping_cost*$Redemptionratio);
                                            $Weighted_avg_shipping_pts=(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
                                            $Weighted_avg_shipping_pts=number_format((float)$Weighted_avg_shipping_pts, 2);
                                            $Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
                                            // echo "<br><b>Shipping_cost </b>".$Shipping_cost;
                                        }
                                }
                                elseif($Shipping_charges_flag==1)//Standard Charges
                                {
                                        if($item["Redemption_method"]==29)
                                        {
                                            $Cost_Threshold_Limit2=round($Cost_Threshold_Limit*$Redemptionratio);
                                            if($Sub_total2 >= $Cost_Threshold_Limit2)
                                            {	
                                                    $Shipping_pts=round($Standard_charges*$Redemptionratio);
                                                    $Weighted_avg_shipping_pts=round(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
                                                    $Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
                                            }
                                            else
                                            {
                                                    $Shipping_pts=0;
                                                    $Weighted_avg_shipping_pts=0;
                                                    $Total_Weighted_avg_shipping_pts[]=0;
                                            }
                                            // echo "<br><b>Standard_charges </b>".$Standard_charges;
                                        }
                                }
                                else
                                {
                                    $Shipping_pts=0;
                                    $Weighted_avg_shipping_pts=0;
                                    $Total_Weighted_avg_shipping_pts[]=0;
                                }

                                // echo "<br><b>Shipping_pts </b>".$Shipping_pts;
                                // echo "<br><b>Weighted_avg_shipping_pts </b>".$Weighted_avg_shipping_pts;
                                $Sub_Total[]=$item["Total_points"];

                        ?>								
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">
                                        <a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo $item['Company_merchandise_item_id']; ?>">
                                            <div class="col-xs-4" style="padding: 2px 8px 0px 10px">
                                                <img src="<?php echo $item["Thumbnail_image1"]; ?>" alt="<?php echo $item["Merchandize_item_name"]; ?>" class="img-rounded img-responsive" width="50" height="70">
                                            </div>
                                        </a>
                                        <div class="col-xs-8 text-left" style="width: 65%;">
                                            <address>
                                                <strong id="Medium_font"><?php echo $item["Merchandize_item_name"]; ?></strong><br>
                                                <div id="Best">													
                                                        <strong id="Medium_font">Quantity </strong>: 
                                                        <strong id="Value_font"><?php echo $item["Quantity"]; ?></strong>
                                                </div>
                                            </address>
                                            <address>
                                                <strong id="Value_font" style="margin-left: 70%;"><?php
                                                        echo $item["Total_points"].'.'.''.$Company_Details->Currency_name;
                                                        ?>
                                                </strong><br>
                                            </address>
                                        </div>
                                        <input type="hidden" name="Hidden_Weighted_avg_shipping_pts_<?php echo $item['Temp_cart_id']; ?>" id="Hidden_Weighted_avg_shipping_pts_<?php echo $item['Temp_cart_id']; ?>" value="<?php echo $Weighted_avg_shipping_pts;?>">
                                    </div>
				</div>
                            </div>
			</div>
                            <?php }
                            $lv_Sub_Total=array_sum($Sub_Total);
                            $Total_Shipping_Points=array_sum($Total_Weighted_avg_shipping_pts);
                            $Grand_total=($lv_Sub_Total+$Total_Shipping_Points);

                            // echo"---Redeem_amount----".$_SESSION["Redeem_amount"]."---<br>";
                            // echo"---Final_Grand_total----".$_SESSION["Final_Grand_total"]."---<br>";
                            ?>		
                            <!-- 4 card -->
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">									
                                       <div class="col-xs-12"  align="center" style="width:100%">
									   <?php /* ?>
                                            <span align="left" style="line-height: 22px;">
                                                <strong id="Medium_font">Sub-Total</strong><br>
                                                <strong id="Medium_font">Delivery Points</strong><br>
                                                <strong id="Medium_font">Total </strong>
                                            </span>
                                            <span align="left" >
                                                     <span id="Value_font">:&nbsp;<?php echo ($lv_Sub_Total); ?> Pts</span><br>
                                                     <span id="Value_font">:&nbsp;<?php echo $Total_Shipping_Points ?> Pts</span><br>
                                                     <span id="Value_font">:<font id="Grand_total"> pts<?php 
										echo $Grand_total; ?> pts</font></span>
                                            </span> <?php */ ?>
                                           
                                        
										
										
										
										<div style="overflow-x:auto;">
											<table>
												<tr>
													<td colspan="2" align="center"><hr />Redeem <?php echo $Company_Details->Currency_name; ?>  Details<hr /></td>
												</tr>
												<tr>
													<td><strong id="Medium_font">Sub-Total</strong></td>
													<td><span id="Value_font">: <?php echo $lv_Sub_Total; ?> <?php echo $Company_Details->Currency_name; ?> </span></td>												  
												</tr>
												<tr>
													<td><strong id="Medium_font">Delivery <?php echo $Company_Details->Currency_name; ?> </strong></td>
													<td><span id="Value_font">: <?php echo $Total_Shipping_Points; ?> <?php echo $Company_Details->Currency_name; ?> </span></td>												  
												</tr>												
												<tr>
													<td><strong id="Medium_font">Total <?php echo $Company_Details->Currency_name; ?> </strong></td>
													<td><span id="Value_font">: <font id="Grand_total"><?php 
														echo $Grand_total; ?> <?php echo $Company_Details->Currency_name; ?> </font></span></td>												  
												</tr>
												<tr>
													<td colspan="2" align="center"><hr />Delivery Information<hr /></td>
																									
												</tr>
												<tr>
													<td><strong id="Medium_font">Name</strong></td>
													<td><span id="Value_font">: <?php echo $firstname." ".$lastname; ?></span></td>
												</tr>
												<tr>
													<td><strong id="Medium_font">Address</strong></td>
													<td><span id="Value_font">: <?php echo $address; ?></span></td>
												</tr>
												<tr>
													<td><strong id="Medium_font">Zipcode</strong></td>
													<td><span id="Value_font">: <?php echo $zip; ?></span></td>
												</tr>
												<tr>
													<td><strong id="Medium_font">Phone no</strong></td>
													<td><span id="Value_font">: <?php echo $phone; ?></span></td>
												</tr>
												<tr>
													<td><strong id="Medium_font">Email id</strong></td>
													<td><span id="Value_font">: <?php echo $email; ?></span></td>
												</tr>
																							
											</table>
										</div>
									 </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 4 card -->
							<?php /*  ?>
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">
										
											<div class="col-xs-12 text-right" >
												<strong id="Medium_font" align="left" style="margin-right: 84px;">Delivery Information</strong><br>
													<span align="left" style="line-height: 22px;">
															<strong id="Medium_font">Name</strong><br>
															<strong id="Medium_font">Address</strong><br>
															<strong id="Medium_font">Zipcode</strong><br>
															<strong id="Medium_font">Phone no </strong><br>
															<strong id="Medium_font">Email id</strong>
													</span>
													<span align="left" >

															 <span id="Value_font">:&nbsp;<?php echo $firstname." ".$lastname; ?></span><br>
															 <span id="Value_font">:&nbsp;<?php echo $address; ?></span><br>
															 <span id="Value_font">:&nbsp;<?php echo $zip; ?></span><br>
															 <span id="Value_font">:&nbsp;<?php echo $phone; ?></span><br>
															 <span id="Value_font">:&nbsp;<?php echo $email; ?></span>
													</span>											
								</div>
										</div>
								</div>
							</div><hr>
							<?php */ ?>
						
						<!-- Cart Details -->
							
			<div class="pricing-details">
				<div class="row">
						<div class="col-xs-4 main-xs-6 text-left" >
								<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_Get_Shipping_details();" >Back</button>
						</div>

						<div class="col-xs-4 main-xs-6 text-right">
							<input type="hidden" name="Current_balance" value="<?php echo $Enroll_details->Current_balance;?>">
							<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
							<input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
							<input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
							<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
							<input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">
							<input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
							<input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
							<input type="hidden" name="address" value="<?php echo $address; ?>">
							<input type="hidden" name="city" value="<?php echo $city; ?>">
							<input type="hidden" name="zip" value="<?php echo $zip; ?>">
							<input type="hidden" name="state" value="<?php echo $state; ?>">
							<input type="hidden" name="country" value="<?php echo $country; ?>">
							<input type="hidden" name="phone" value="<?php echo $phone; ?>">
							<input type="hidden" name="email" value="<?php echo $email; ?>">
							
							
									<?php if($Exist_Delivery_method==1){
									if($Enroll_details->Total_balance >= $Grand_total){
									 ?>
										<button type="submit"  name="submit"  id="proceed"  > Complete </button>
									<?php } else { ?>
										<strong id="Medium_font">Insufficient Current Balance !!!</strong>
									<?php } } else { ?>                                                
										<button type="submit" name="submit"  id="proceed"  >Finish</button>
									<?php } ?>
							 
								
						</div>
				</div>
            </div>
            <hr>
            <?php } ?>	
            <!-- 6th Sub -->
            <?php if(empty($Redemption_Items)) { ?>

                    <div class="pricing-details">
                        <div class="row">
                            <div class="col-md-12">			
                                <address>
                                    <button type="button" id="button1" onclick="return Go_to_redeem();">Continue Redeem</button>
                                </address>
                            </div>
                        </div>
                    </div>

            <?php } ?>
									
        </div>		
					<!-- End -->
    </div>
</div>
</div>
</div>
	<?php echo form_close(); ?>	
	
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
   <?php $this->load->view('front/header/footer');?> 
<script>
    
    function Go_to_redeem()
    { 
        setTimeout(function() 
        {
            $('#myModal').modal('show');
            window.location.href='<?php echo base_url(); ?>index.php/Redemption_Catalogue';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },1000);
    }
    function Go_to_Get_Shipping_details()
    { 
        setTimeout(function() 
        {
            $('#myModal').modal('show');	
            window.location.href='<?php echo base_url(); ?>index.php/Redemption_Catalogue/Get_Shipping_details';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
           
        },2000);
    }
$('#continue').click(function()
{
	
	 setTimeout(function() 
        {
            $('#myModal').modal('show');	
            
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
           
        },2000);	
});

var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
var Redeemtion_limit = <?php echo $Redeemtion_limit; ?>;
var Tier_name = '<?php echo $Tier_name; ?>';
var Total_balance=<?php echo $Enroll_details->Total_balance;?>;

$('#proceed').click(function()
{   
    setTimeout(function() 
    {
        $('#myModal').modal('show');	
		
		if(Total_balance >= Redeemtion_limit)
		{
			return true;
		}
		else
		{
			var msg1 = 'Sorry ! You can not redeem as your Current Balance is less than Minimum required for your Tier'+Tier_name+' You need atleast'+Redeemtion_limit+'Current balance to Redeem';
			 $('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg1);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
			return false;
		}  
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');

    },4000);     
});
   
var Grand_total2=document.getElementById("Hidden_Grand_total").value;
document.getElementById("Grand_total").innerHTML=Grand_total2+" <?php echo $Company_Details->Currency_name; ?>";

if(Grand_total2 > Total_balance)
{
	//ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
	
	document.getElementById("proceed").style.display="none";
}

function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
 
  if (charCode == 46 || charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}

function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	setTimeout('HidePopup()', 10000);
}

function HidePopup()
{
	$('#popup').hide();
}
</script>
</script>
<style>	
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
	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
	}	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}	
	.main-xs-6
	{
		width: 50%;
		padding: 10px 10px 0 10px;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	#bill{
		color: #ff3399;
		font-weight:bold;
	}	
	#bill1{		
		margin-right: 5%;
		
		/* float: right;
		margin-right: 5%;
		width: 66%; */		
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
</style>