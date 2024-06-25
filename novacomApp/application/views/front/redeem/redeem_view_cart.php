<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Redeemed Items</title>	
	<?php $this->load->view('front/header/header');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 
  </head>
<body>   
   <?php
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
        //print_r($Redemption_Items);
        $Delivery_method=0;
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
        if($item_count <= 0 )
		{
            $item_count=0;
        }
        else 
		{
            $item_count = $item_count;
        }						      
    ?> 
		<?php
               
			if($Redemption_Items != "") {
				if($Delivery_method==1){
				echo form_open('Redemption_Catalogue/Get_Shipping_details');
				} else {
				 echo form_open('Redemption_Catalogue/Insert_Redeem_Items');
				} 
			} 
		?>
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Cust_home/Redeemption_menu" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Redeemed Items</p>
			</div>
			<div class="row pricing-tables">			
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
					<!-- Main Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
					
					<?php if(!empty($Redemption_Items)) { ?>	<!-- 1 card -->						
					<?php 
                                        
                                        $Exist_Delivery_method=0;
                                        if(isset($_SESSION["To_Country"]))
                                        {
                                            $To_Country=$_SESSION["To_Country"];
                                            $To_State=$_SESSION["To_State"];
                                        }
                                        $Sub_total2=0;
                                        foreach ($Redemption_Items as $item2) 
                                        {									
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

                                          
                                            $Sub_Total[]=$item["Total_points"];
					?>
						
											
                                        <div class="pricing-details">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row ">
                                                        <div class="col-xs-4" style="padding: 2px 8px 0px 10px">

                                                                <img src="<?php echo $item["Thumbnail_image1"] ?>" alt="<?php echo $item["Merchandize_item_name"]; ?>" class="img-rounded img-responsive" width="80" height="60">

                                                        </div>
                                                        <div class="col-xs-8 text-left" style="width: 65%;">
                                                            <address>
                                                                    <strong id="Medium_font"><?php echo $item["Merchandize_item_name"]; ?></strong><br>
                                                            </address>
                                                            <address>
                                                                    <strong id="Value_font" style="float: right;" ><?php
                                                                            //$grand_total = $grand_total + $item['subtotal'];
                                                                            //echo number_format((float)$item['subtotal'], 2);
                                                                    
                                                                            echo $item["Total_points"].' '.$Company_Details->Currency_name;
                                                                            ?>
                                                                    </strong><br>
                                                            </address>
                                                            
                                                                     <input type="hidden" name="Hidden_Weighted_avg_shipping_pts_<?php echo $item['Temp_cart_id']; ?>" id="Hidden_Weighted_avg_shipping_pts_<?php echo $item['Temp_cart_id']; ?>" value="<?php echo $Weighted_avg_shipping_pts;?>">
                                                            <span style="color: #ff3399;margin-bottom: 0;">												
                                                                <div id="Best">													
																		<strong id="Medium_font">Quantity</strong>
                                                                        <button type="button" class="<?php echo $item['Company_merchandise_item_id']; ?> decr" id="Best_decr" id="button1"  onclick="Update_cart(<?php echo $item["Quantity"]; ?>,'<?php echo $item["Item_code"]; ?>','<?php echo $item["Branch"]; ?>','<?php echo $item["Points"]; ?>','<?php echo $item["Size"]; ?>','<?php echo $item["Redemption_method"]; ?>','<?php echo $item["Weight"]; ?>','<?php echo $item["Weight_unit_id"]; ?>',0)">-</button>
                                                                        <input type="text" value="<?php echo $item["Quantity"]; ?>" id="qty_<?php echo $item['Company_merchandise_item_id']; ?>"  name="Quantity" pattern='[0-9]*'  style="width: 25%;text-align: center;" readonly />
                                                                        <button type="button" class="<?php echo $item['Company_merchandise_item_id']; ?> incr" id="Best_incr"  onclick="Update_cart(<?php echo $item["Quantity"]; ?>,'<?php echo $item["Item_code"]; ?>','<?php echo $item["Branch"]; ?>','<?php echo $item["Points"]; ?>','<?php echo $item["Size"]; ?>','<?php echo $item["Redemption_method"]; ?>','<?php echo $item["Weight"]; ?>','<?php echo $item["Weight_unit_id"]; ?>',1)">+</button>
                                                                       
                                                                </div>
																<div id="alert_div_<?php echo $item["Item_code"]; ?>"></div>
																<br />
                                                            </span>
															<br />
															<address>																								
                                                                   <a href="#" onclick="delete_item('<?php echo $item['Item_code']; ?>','<?php echo $item['Merchandize_item_name']; ?>','<?php echo $item['Branch']; ?>','<?php echo $item['Total_points']; ?>','<?php echo $item['Size']; ?>','<?php echo $item["Redemption_method"]; ?>')">
                                                                            <strong id="Medium_font">Remove </strong> <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/remove.png" alt="" class="img-rounded img-responsive" width="20">
                                                                    </a>
                                                            </address>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><hr />
					<?php } ?>
						
					
                      <?php             $lv_Sub_Total=array_sum($Sub_Total);
                                        $Total_Shipping_Points=array_sum($Total_Weighted_avg_shipping_pts);
                                        $Grand_total=($lv_Sub_Total+$Total_Shipping_Points);
					
					?>	<!-- 4 card -->
                                            <div class="pricing-details">
                                                <div class="row">
                                                    <div class="col-md-12">									
                                                        <div class="col-xs-12" align="center" style="width:100%">
                                                           
															<?php /* ?><span align="left" style="line-height: 22px;">
                                                                    <strong id="Medium_font">Sub-Total</strong><br>
                                                                    <strong id="Medium_font">Delivery Points</strong><br>
                                                                    <strong id="Medium_font">Total: 
                                                            </span>
                                                            <span align="left">
                                                                     <span id="Small_font">:&nbsp;<font id="Value_font"><?php echo $lv_Sub_Total; ?> Pts</font></span><br>
                                                                     <span id="Small_font">:&nbsp;<font id="Value_font"><?php echo $Total_Shipping_Points; ?> Pts</font></span><br>
                                                                     <span id="Small_font">:&nbsp;<font id="Value_font"><?php echo $Grand_total; ?> Pts</span></font></strong>
                                                            </span>
															<?php */ ?>
															
															
															<div style="overflow-x:auto;">
															<table>
																<tr>
																	<td colspan="2" align="center"><hr />Details<hr /></td>
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
																	<td><span id="Value_font">: <?php echo $Grand_total; ?> <?php echo $Company_Details->Currency_name; ?> </span></td>												  
																</tr>												
															</table>
														</div>
															
                                                        </div>
														
														
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="pricing-details">
                                                <div class="row">
                                                    <div class="col-xs-4 main-xs-6 text-left" style="width:50%">
                                                       <button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_redeem();" >Go Back</button>
                                                    </div>
                                                    <input type="hidden" name="Current_balance" value="<?php echo $Enroll_details->Current_balance;?>">
                                                    <input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
                                                    <input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
                                                    <input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
                                                    <input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
                                                    <input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">

                                                    <div class="col-xs-4 main-xs-6 text-right" style="width:50%">
                                                             <!--<span id="button" class="b-items__item__add-to-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to cart</span>-->
                                                        <?php if($Exist_Delivery_method==1) { ?>                                                        
                                                            <button type="submit" name="submit" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_proceed();"  > Proceed</button>
                                                        <?php } else  { ?>
                                                             <button type="submit" name="submit" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_checkout();"  > Complete</button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
								<hr />
						<?php } ?>	
						<!-- 6th Sub -->
						<?php if(empty($Redemption_Items)) { ?>
							
							<div class="pricing-details">
								<div class="row">
									<div class="col-md-12">			
										<address>
											<button type="button" id="button1" onclick="return Go_to_redeem();">Go Back</button>
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
 
	<link rel="stylesheet" type="text/css"  href="<?php echo base_url();?>assets/css/jquery-confirm.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.js"></script>
<script>  
    function Go_to_checkout()
    { 
        setTimeout(function() 
        {
            $('#myModal').modal('show');
           
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },1000);
    }
    function Go_to_proceed()
    { 
        setTimeout(function() 
        {
            $('#myModal').modal('show');
           
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },1000);
    }
    function Go_to_redeem()
    { 
        setTimeout(function() 
        { 
            $('#myModal').modal('show');
            window.location.href='<?php echo base_url(); ?>index.php/Cust_home/Redeemption_menu';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },1000);
    }
    
function Update_cart(Qty,Item_code,Branch,Points,Size,Redemption_method,Item_Weight,Weight_unit_id,type)
{
	if(type==0)
	{
		Qty=parseInt(Qty) - 1;
	}
	else if(type==1)
	{
		Qty=parseInt(Qty) + 1;
	}
   
	setTimeout(function() 
	{
			$('#myModal').modal('show');	
	}, 0);
	setTimeout(function() 
	{ 
			$('#myModal').modal('hide');	
	},2000);
	
		
	var Total_balance = <?php echo $Current_point_balance;?>;
	// var Current_redeem_points=$('#cart_count').val();
	var Current_redeem_points='<?php echo $item_count; ?>';
	Current_redeem_points=(parseInt(Current_redeem_points)+parseInt(Points));
	
	if(type==1 && Current_redeem_points > Total_balance)
	{
		// ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
		// alert('Insufficient Current Balance');
		var msg1 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance';
		$('#alert_div_'+Item_code).show();
		$('#alert_div_'+Item_code).css("color","red");
		$('#alert_div_'+Item_code).html(msg1);
		setTimeout(function(){ $('#alert_div_'+Item_code).hide(); },3000);
		return false;
	}	
	else if(parseInt(Qty) != 0 )
	{
		var Grand_total2=$("#cart_count").val();
		
		$.ajax({
			type:"POST",
			data:{Item_code:Item_code,Qty:Qty,Branch:Branch,Points:Points,Total_Redeem_points:Grand_total2,Size:Size,Redemption_method:Redemption_method,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id},
			url: "<?php echo base_url()?>index.php/Redemption_Catalogue/Update_Merchandize_Cart",
			success: function(data)
			{
				window.top.location.reload(); 
			}				
		});
	}
	
}

 // confirmation
                   
	function delete_item(Item_code,Merchandize_item_name,Branch,Total_points,Size,Redemption_method)
	{	
			$.confirm({
					title: 'Item Delete Confirmation',
					content: 'Are you sure to delete '+Merchandize_item_name+' item from the cart?',
					icon: 'fa fa-question-circle',
					animation: 'scale',
					closeAnimation: 'scale',
					opacity: 0.5,
					buttons: {
						'confirm': {
							text: 'OK',
							btnClass: 'btn-default',
							action: function () {
								$.confirm({
									title: 'Item will be deleted from the cart.',
									content: 'Please click on OK to Continue.',
									icon: 'fa fa-warning',
									animation: 'scale',
									closeAnimation: 'zoom',
									buttons: {
										confirm: {
											text: 'OK',
											btnClass: 'btn-default',
											action: function () {
												
												setTimeout(function() 
												{
														$('#myModal').modal('show');	
												}, 0);
												setTimeout(function() 
												{ 
														$('#myModal').modal('hide');	
												},2000); 
												
												var Grand_total2=$("#cart_count").val();
												var Total_Redeem_points=(Grand_total2-Total_points);
											   	$.ajax({
														type:"POST",
														data:{Item_code:Item_code, Branch:Branch, Total_Redeem_points:Total_Redeem_points,Size:Size,Redemption_method:Redemption_method},
														url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
														success: function(data)
														{
																 
																
																// window.top.location.reload();
																//location.reload(true);
															window.location.href='<?php echo base_url(); ?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue';
														}				
												});
											}
										},
										cancel: function () {
											//$.alert('you clicked on <strong>cancel</strong>');
										}
									}
								});
							}
						},
						cancel: function () {
							//text: 'Proceed',
							//btnClass: 'Button_font',
							//$.alert('you clicked on <strong>cancel</strong>');
						},
					}
				});
						
		// return false;
		/* var Grand_total2=$("#cart_count").val();
		var Total_Redeem_points=(Grand_total2-Total_points);
		$.ajax({
				type:"POST",
				data:{Item_code:Item_code, Branch:Branch, Total_Redeem_points:Total_Redeem_points,Size:Size,Redemption_method:Redemption_method},
				url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
				success: function(data)
				{
					
				}				
		}); */

}
</script>

<style>
	
	.btn-default
	{
		color:<?php echo $Button_font_details[0]['Button_font_color'];?> !IMPORTANT;
		font-family:<?php echo $Button_font_details[0]['Button_font_family'];?> !IMPORTANT;
		font-size:<?php echo $Button_font_details[0]['Button_font_size'];?> !IMPORTANT;
		background:<?php echo $Button_font_details[0]['Button_background_color'];?> !IMPORTANT;
		border-radius:7px !IMPORTANT;
		
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?> !IMPORTANT;
		width: 115px !IMPORTANT;
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
	
	address{
		margin:0% 0% 2% 0%;
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