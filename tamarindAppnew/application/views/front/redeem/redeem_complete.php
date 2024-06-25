<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Redemption Complete</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
   <?php 
        //print_r($Redemption_Items);
        $item_count=0;
       /* if($Redemption_Items != "") {
            foreach($Redemption_Items as $item)
            {
                $item_count=$item_count+$item["Total_points"]; 
                if($item["Redemption_method"]==29)
		{
			$Delivery_method=1;
		}
            }
        }*/
        if($item_count <= 0 ) {
                $item_count=0;
        }
        else {
                $item_count = $item_count;
        }
        //$Pin_no_applicable=1;
    ?>  
  </head>
<body> 
   
    <div id="application_theme" class="section pricing-section" style="min-height:720px;">
        <div class="container">
            <div class="section-header">          
                    <p><a href="<?php echo base_url(); ?>index.php/Redemption_Catalogue" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                    <p id="Extra_large_font">Redemption Complete</p>
            </div>
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
                    <!-- Main Card -->
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">						
                        <!-- 4 card -->
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
								<?php $Img='assets/icons/'.$Img.'.png'?>
									<img src="<?php echo base_url(); ?><?php echo $Img; ?>" alt="" class="img-rounded img-responsive" style="width:20%; border-radius: 3%;">
									<br>
									<strong id="Message"><?php echo $Success_Message; ?></strong>
                                </div>
                            </div>
                        </div><hr>						
                        <div class="pricing-details">
                            <div class="row">
                                    <div class="col-xs-4 main-xs-6" >
                                        <button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_redeem();" >Redeem Now</button>
                                    </div>
                                    <div class="col-xs-4 main-xs-6" >									 
                                        <button type="button" id="button1" class="b-items__item__add-to-cart"  onclick="window.location.href='<?php echo base_url(); ?>index.php/Cust_home/front_home'"> Redeem Again</button>
                                    </div>
                            </div>
                        </div>
                        <br>
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
            window.location.href='<?php echo base_url(); ?>index.php/Cust_home/Redeemption_menu';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },1000);
    }
    </script>
<style>
	#Message
	{
		color:<?php echo $MColor; ?>;
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
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
	}
	
	#prodname1{
		color: #ff3399;
		margin-left: 60%;
		font-size:12px;
	}
	
	#bill{
		color: #ff3399;
		font-weight:bold;
	}
	
	#bill1{
		margin-left:42%;
	}
	
	#sub{
		color: #7d7c7c;
		font-size: 12px;
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