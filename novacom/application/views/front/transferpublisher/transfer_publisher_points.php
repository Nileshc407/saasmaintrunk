<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Transfer Publisher </title>	
	<?php $this->load->view('header/header');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }	?> 
  </head>
  <body>
  <?php echo form_open_multipart('Transfer_publisher/Transfer_publisher_topublisher_points',array('onsubmit' => 'return ValidateData();'));	?>
  
	<?php /* ?>
      <form  name="search_publisher" method="POST" action="<?php echo base_url()?>index.php/Transfer_publisher/Transfer_publisher_topublisher_points" enctype="multipart/form-data" onsubmit="return ValidateData();">      
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container">
            
                          
                <div class="row pricing-tables">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                            <div class="pricing-details">
                                <div class="row ">
                                    
                                    
                                    <div class="col-xs-12"> 
                                        <strong><img src="<?php echo $this->config->item('base_url2'); ?><?php echo $From_publisher_details->Company_logo ?>" style="width: 30%;"> <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" > <img src="<?php echo $this->config->item('base_url2'); ?><?php echo $To_publisher_details->Company_logo ?>" style="width: 30%;"></strong><br>
                                        <!--<strong style="float:center"><?php //echo $From_beneficiary_id; ?> | <?php //echo $To_beneficiary_id; ?></strong>-->
                                    </div>
                                </div>
                            </div>
                            <div class="pricing-details">
                                <div class="row ">
                                    
                                    <div class="col-xs-12 " style="width: 100%;">
                                        <address>
                                            <div class="col-xs-12" > 
                                                
                                                    
                                                                                           
                                            </div>
                                            <div class="col-xs-12" style="margin-top:5px;"> 
                                               <b id="Publisher_balance"><?php echo $From_publisher_details->Beneficiary_company_name; ?> <br />Balance: <?php echo $Publisher_current_balance; ?> <?php echo $From_publisher_details->Currency; ?></b>
											   
                                            </div>
                                           
                                        </address>
                                            <div class="col-xs-12" style="margin-top:5px;"> 
                                                    <strong id="Value_font"> (1 <?php echo $From_publisher_details->Currency; ?> =  <?php echo number_format($From_publisher_details->Redemptionratio/$To_publisher_details->Redemptionratio,4); ?>  <?php echo $To_publisher_details->Currency; ?>)</strong>
                                            </div>
                                            <div class="col-xs-12" style="margin-top:5px;"> 
                                               <b id="CurrentBalance" style="display:none;"><?php echo $From_publisher_details->Beneficiary_company_name; ?> : <b id="PublisherCurrentBalance_div"></b> <?php echo $From_publisher_details->Currency; ?></b>
                                            </div>
                                        <ul>
                                           <li id="Small_font" class="text-left">
                                                <input type="tel"  name="Transfer_miles" id="Transfer_miles" onchange="Get_Equi_points(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"  placeholder="Enter <?php echo $From_publisher_details->Currency; ?> to transfer" class="txt" style="text-align:center;" autocomplete="off">
                                                
                                            </li>						 
                                            <li id="Small_font" class="text-left"> 				
                                                <input type="text" name="Equivalent" id="Equivalent" placeholder="Equivalent <?php echo $To_publisher_details->Currency; ?>" class="txt" readonly style="text-align:center;"> 
                                                
                                            </li>
                                        </ul>
                                        <address> 
                                            <div id="PublisherBalance_div" ></div>
                                           <input type="hidden" name="From_publisher" value="<?php echo $From_publisher; ?>">
                                           <input type="hidden" name="From_beneficiary_id" value="<?php echo $From_beneficiary_id; ?>">
                                           <input type="hidden" name="To_publisher" value="<?php echo $To_publisher; ?>">
                                           <input type="hidden" name="To_beneficiary_id" value="<?php echo $To_beneficiary_id; ?>">
                                           <input type="hidden" name="Publisher_current_balance" value="<?php echo $Publisher_current_balance; ?>">
                                           <input type="hidden" name="From_user_email_address" value="<?php echo $From_user_email_address; ?>">
                                           <input type="hidden" name="To_user_email_address" value="<?php echo $To_user_email_address; ?>">
                                           
                                           <button  type="submit" id="button1" name="submit">Submit</button><br>

                                           <br>
                                        </address>
                                        <br />
                                   </div>
                                </div>
                            </div>                                            
                        </div>                   
                    </div>
                </div>  
        </div>
    </div>
  </form>
  <?php */ ?>
  
  
  <section class="content-header">
		<h1> Transfer Points</h1>         
	</section>  
	<section class="content">
        <div class="row">				
			<div class="panel panel-info" style="margin-bottom:0px">
				<div class="panel-heading text-center">
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-center">From Publisher Accounts</h4>
							
						</div>
						<div class="col-md-6">
							
							<h4 class="text-center">To Publisher Accounts</h4>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12 text-center">
						<b id="Publisher_balance">  ( 1 <?php echo $From_publisher_details->Currency; ?> =  <?php echo number_format($From_publisher_details->Redemptionratio/$To_publisher_details->Redemptionratio,4); ?>  <?php echo $To_publisher_details->Currency; ?> )</b>
					<br>
						<b id="Publisher_balance"><?php echo $From_publisher_details->Beneficiary_company_name; ?> Balance: <?php echo $Publisher_current_balance; ?> <?php echo $From_publisher_details->Currency; ?></b>
					</div>
				</div>
				<br>
				<br>
				
				
				
				
				<div class="col-md-5 bhoechie-tab-menu" >
					<div class="list-group">
					
						<a href="javascript:void(0);"  class="list-group-item text-center" >						
							<div class="row">
								<div class="col-lg-4">
								
									<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $From_publisher_details->Company_logo ?>" class="img-responsive"  ><br>
										<span><?php echo $From_publisher_details->Beneficiary_company_name; ?></span>
										
								</div><!-- col-lg-6 -->
								<div class="col-lg-8">
									<div class="col-lg-12">
										<div class="col-lg-3 text-left">Name </div>
										<div class="col-lg-9 text-left">: <?php echo $Get_Beneficiary_members->Beneficiary_name; ?> </div>
									</div><!-- col-lg-12 -->
									<div class="col-lg-12">
										<div class="col-lg-3 text-left">Identifier </div>
										<div class="col-lg-9 text-left">: <?php echo $Get_Beneficiary_members->Beneficiary_membership_id; ?></div>
										
									</div><!-- col-lg-12 -->
								</div><!-- col-lg-6 -->
							</div><!-- /.row -->
						</a>
												
					</div>
				</div>
				
				<div class="col-md-2 bhoechie-tab-menu" >
				
					
					<div class="list-group">
										
						<a href="javascript:void(0);"  class="list-group-item text-center" >						
							<div class="row">
								<div class="col-lg-12">
								
									<img src="<?php echo base_url(); ?>assets/icons/right.png" width="60" > 
										
										
								</div><!-- col-lg-6 -->
								
							</div><!-- /.row -->
						</a>
					</div>
				</div>
				<div class="col-md-5 bhoechie-tab-menu">
					<div class="list-group">
											
						<a href="javascript:void(0);" class="list-group-item text-center" >
							<div class="row">
								<div class="col-lg-4">
								
										<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $To_publisher_details->Company_logo ?>"  class="img-responsive" > <br>
										<span><?php echo $To_publisher_details->Beneficiary_company_name ?></span>
										
								</div><!-- col-lg-6 -->
								<div class="col-lg-8">									
									<div class="col-lg-12">
										<div class="col-lg-3 text-left">Name </div>
										<div class="col-lg-9 text-left">: <?php echo $To_get_Beneficiary_members->Beneficiary_name; ?> </div>
									</div><!-- col-lg-12 -->
									<div class="col-lg-12">
										<div class="col-lg-3 text-left">Identifier </div>
										<div class="col-lg-9 text-left">: <?php echo $To_get_Beneficiary_members->Beneficiary_membership_id; ?></div>
										
									</div><!-- col-lg-12 -->
									
									
									
								</div><!-- col-lg-6 -->
							</div><!-- /.row -->
						</a>
					</div>
				</div>
			</div>
		</div><!-- /.row -->
		
		<div class="row">	
			<div class="login-box">
			  <div class="login-box-body">
				<p class="login-box-msg"> </p>
				<form action="#" method="post">
					<div class="form-group has-feedback">
						<label for="exampleInputEmail1"> Enter <?php echo $From_publisher_details->Currency; ?></label>
						<input type="text" name="Transfer_miles" id="Transfer_miles" onchange="Get_Equi_points(this.value);" onkeyup="this.value=this.value.replace(/\D/g,'')"  placeholder="Enter <?php echo $From_publisher_details->Currency; ?> to transfer" class="form-control"  autocomplete="off" />						
						<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
						<div class="help-block"></div>
					</div>
					<div class="form-group has-feedback">
						<label for="exampleInputEmail1"> Equivalent <?php echo $To_publisher_details->Currency; ?></label>
						<input type="text" name="Equivalent" id="Equivalent" placeholder="Equivalent <?php echo $To_publisher_details->Currency; ?>" class="form-control" readonly />						
						<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
						<div class="help-block"></div>
					</div>
				 
				  <div class="row">
					
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat" onclick="check_promo_code();">Submit</button>
						<input type="hidden" name="From_publisher" value="<?php echo $From_publisher; ?>">
						   <input type="hidden" name="From_beneficiary_id" value="<?php echo $From_beneficiary_id; ?>">
						   <input type="hidden" name="To_publisher" value="<?php echo $To_publisher; ?>">
						   <input type="hidden" name="To_beneficiary_id" value="<?php echo $To_beneficiary_id; ?>">
						   <input type="hidden" name="Publisher_current_balance" value="<?php echo $Publisher_current_balance; ?>">
						   <input type="hidden" name="From_user_email_address" value="<?php echo $From_user_email_address; ?>">
						   <input type="hidden" name="To_user_email_address" value="<?php echo $To_user_email_address; ?>">
					</div><!-- /.col -->
				  </div>
				</form>


			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
		</div><!-- /.row -->
		
	</section><!-- /.content -->
	
        <?php echo form_close(); ?>
        </section><!-- /.content -->
		<?php $this->load->view('header/loader');?> 
      <?php $this->load->view('header/footer');?>	
  </body>
  <script>
 
 
  /* function FetchPublisherBalance(PublisherID, FromBeneficiaryID) {
      
        if(PublisherID == "" ){

            var msg1 = 'Invalid Publisher.';
            $('#PublisherBalance_div').show();
            $('#PublisherBalance_div').css('color','red');
            $('#PublisherBalance_div').html(msg1);
            setTimeout(function(){ $('#PublisherBalance_div').hide(); }, 3000);
            return false;
        }
        else if(FromBeneficiaryID == "" ){

            var msg1 = 'Invalid Identifier.';
            $('#PublisherBalance_div').show();
            $('#PublisherBalance_div').css('color','red');
            $('#PublisherBalance_div').html(msg1);
            setTimeout(function(){ $('#PublisherBalance_div').hide(); }, 3000);
            return false;
            
        } else {
            
           // alert(PublisherID+'-----------'+FromBeneficiaryID);
           
    
        
        
            $.ajax({
                type: "POST",
                data:{ PublisherID:PublisherID , FromBeneficiaryID:FromBeneficiaryID},
                url: "<?php echo base_url()?>index.php/Transfer_publisher/Get_publisher_current_balance",
                dataType: "json", 
                success: function(json)
                {      

                    var error = json['status'];
                     //alert(error);
                    if(error==1001) {
                        
                        $('#CurrentBalance').css("display","");
                        $('#PublisherCurrentBalance_div').html(json['status_message']);
                         
                    } else {
                        
                        $('#CurrentBalance').css("display","");
                        $('#CurrentBalance').html('Invalid Data Provide');
                    }

                }
            });
        }    
    } */
	
    function Get_Equi_points(Points)
    {
        var Login_Redemptionratio=<?php echo $Login_Redemptionratio; ?>;
        var fromRedemptionratio=<?php echo $From_publisher_details->Redemptionratio; ?>;
        var toRedemptionratio=<?php echo $To_publisher_details->Redemptionratio; ?>;
        var Publisher_current_balance=parseInt(<?php echo $Publisher_current_balance; ?>);
        if(Points > Publisher_current_balance){
            
            $("#Equivalent").val("");
            $("#Transfer_miles").val("");
            var msg1 = 'Invalid Current Balance';
            $('#PublisherBalance_div').show();
            $('#PublisherBalance_div').css('color','red');
            $('#PublisherBalance_div').html(msg1);
            setTimeout(function(){ $('#PublisherBalance_div').hide(); }, 3000);
            
            return false;
            
        } else {
            
            //alert(Points+'----fromRedemptionratio---'+fromRedemptionratio+'---fromRedemptionratio--'+fromRedemptionratio+'---toRedemptionratio---'+toRedemptionratio);
             //alert('----fromRedemptionratio---'+fromRedemptionratio);
            // alert('----Points---'+Points);
            var New_equivalent_points= Math.round(Points*fromRedemptionratio);
           // alert('----New_equivalent_points---'+New_equivalent_points);
           // alert('----toRedemptionratio---'+toRedemptionratio);             
            var New_equivalent=Math.round(New_equivalent_points/toRedemptionratio);     
           // alert('----New_equivalent---'+New_equivalent);
            $("#Equivalent").val(New_equivalent);
        }        
       
    }
    
    function ValidateData()
    {
		
        if($("#Transfer_miles").val()=="" || $("#Transfer_miles").val()==0 || $("#Equivalent").val()=="" || $("#Equivalent").val()==0 ) {
            
            var Title = "Application Information";
			var msg = 'Transfer miles or Equivalent should be greater than 0';
			runjs(Title,msg);
            return false;         
            
        } else {     
		
			show_loader();		
            return true;
        }      
        
        
       return true;
    }
  </script>
<style>	
#icon{
	float: right;
	 width: 6%;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
	}
</style>
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
	
	address{
		margin-bottom: 0px;
	}	
	body{background: linear-gradient(to bottom right, #41c5a2, #c1c2e7);background-repeat: no-repeat;}	
	.card-span {
		color: #1fa07f !important;
		font-size: 12px !important;
		display: inline;
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
	#search{
		font-size:20px;
		margin-left: 6%;
		color: #1fa07f;
		
	}	
        
        .txt {
       
        border-left-color: -moz-use-text-color;
        border-left-style: none;
        border-left-width: medium;
        border-top-color: -moz-use-text-color;
       
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
	
	   .Joy_points{ 
		color: #008080;
		font-size: 12px;
		background: #fafafa;
		border-radius: 7px;
		margin: 0px;
		border: 1px solid #008080;
		width: 115px;
		padding: 5px;
	   }
	   #CurrentBalance{ 
		color: #008080;		
		background: #fafafa;
		border-radius: 7px;
		margin: 10px;		
		width: 100%;
		padding: 4px;
	   }
	   #Publisher_balance{ 
		color: #008080;		
		background: #fafafa;
		border-radius: 7px;
		margin: 10px;
		width: 100%;
		padding: 4px;
	   }
</style>