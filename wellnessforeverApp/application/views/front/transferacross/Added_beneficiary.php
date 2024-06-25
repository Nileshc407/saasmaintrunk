<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Loyalty Programs</title>
    <?php $this->load->view('front/header/header'); ?>   
    
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container">
            <div class="section-header">
               <p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_publisher_menu" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">My Loyalty Programs</p>
            </div>

            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                    <!-- 1st Card -->
                   
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <div id="Beneficiary_div" ></div>
                        
                       
                       <?php if(empty($Get_Beneficiary_members)) { ?>
							
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">			
                                        <address>
                                            <button type="button" id="button" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary'">No Accounts Found</button>
                                        </address>
                                    </div>
                                </div>
                            </div>

                        <?php } 
						
                                  
							if($Get_Beneficiary_members) {
							?>
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12" style="padding: 20px;" >
                                    <!-- 1 -->
                                    <?php 
                                  
                                    
                                        foreach($Get_Beneficiary_members as $Rec2) {
                                           // echo"---Igain_company_id----".$Rec2->Igain_company_id."--<br>";
                                            $Company_details= $this->Igain_model->get_company_details($Rec2->Igain_company_id);
                                       
                                        if($Rec2->Beneficiary_status==0) {
                                                $Beneficiary_status='Pending';
                                                 $img_name='pending.png';
                                        }
                                        if($Rec2->Beneficiary_status==1) {
                                                $Beneficiary_status='Approved';
                                                 $img_name='approved.png';
                                        }
                                        if($Rec2->Beneficiary_status==2) {
                                                $Beneficiary_status='Not Approved';
                                                $img_name='declined.png';
                                        }
                                        ?>
                                    

                                       
                                            <div class="row ">
                                                
                                                <div class="col-xs-4 text-center"  style="width: 50%;">
                                                    <img src="<?php echo $this->config->item('base_url2');?><?php echo $Rec2->Company_logo; ?>" alt="" class="img-rounded img-responsive" width="80"><br>
                                                     <span id="Value_font"><?php echo $Rec2->Beneficiary_company_name ?></span>
                                                </div>
                                                <div class="col-xs-8 text-left" style="width: 50%;">


                                                    <span id="Medium_font">Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span id="Value_font"><?php echo $Rec2->Beneficiary_name; ?></span><br>
                                                    <span id="Medium_font">Identifier&nbsp;:</span>  <span id="Value_font"><?php echo $Rec2->Beneficiary_membership_id; ?></span><br>

                                                    <a href="javascript:void(0);" onclick="remove_beneficiary(<?php echo $Rec2->Beneficiary_account_id; ?>,'<?php echo $Rec2->Beneficiary_name; ?>');">
                                                        <span id="Medium_font"></span> 
                                                        <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/remove.png" alt="" class="img-rounded img-responsive" width="20">
                                                    </a>
                                                    <span id="Medium_font" style="float:right;margin-right:9px;">
                                                        <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/<?php echo $img_name; ?>" alt="" class="img-rounded img-responsive" width="50">
                                                    </span>
                                                     <?php if($Rec2->Beneficiary_status != 1) { ?>
                                                    
                                                            <span id="Medium_font" style="float:right;margin-right:9px;color: red;">
                                                                <span id="Value_font" style="color:red;"><?php echo $Rec2->Error_message; ?></span><br>
                                                            </span>
                                                        
                                                    <?php } ?>
                                                </div>

                                            </div>
                                           
                                    
                                     <hr style="background:#ffffff;">
                                     <br>

                                        <?php								
                                        }
                                    
                                    ?>
                                   			
                                </div>
                            </div>
                        </div>
						<?php  }
                                   ?>
                    </div>	
                </div>
            </div>
        </div>
    </div>
   
   
    <?php $this->load->view('front/header/footer');?>
	
	<link rel="stylesheet" type="text/css"  href="<?php echo base_url();?>assets/css/jquery-confirm.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.js"></script>
<style>
    #icon{
		float: left;
		width: 30%;
		margin: 11px 11px auto;
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
	
	#button{
		color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
		font-family:<?php echo $Button_font_details[0]['Button_font_family'];?>;
		font-size:<?php echo $Button_font_details[0]['Button_font_size'];?>;
		background:<?php echo $Button_font_details[0]['Button_background_color'];?>;
		border-radius:7px;
		margin:0px;
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
		width: 130px;
	}	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	#img{
		float: right;
		width: 11%;
		margin: 0 11px auto;
	}
</style>

<?php
    if(@$this->session->flashdata('success')) {
    ?>
        <script>
                /* var msg1 = '<?php //echo $this->session->flashdata('success'); ?>';
                // alert(msg);
                // var msg1 = 'Please enter all details..!!';
                $('#Beneficiary_div').show();
                $('#Beneficiary_div').css("color","green");
                
                $('#Beneficiary_div').css("padding-bottom","20px");
                $('#Beneficiary_div').html(msg1);
                setTimeout(function(){ $('#Beneficiary_div').hide(); }, 3000); */
         
        </script>
    <?php
    }
?>
<script>   
                
                
    function remove_beneficiary(Beneficiary_account_id,Beneficiary_name)
	{
		
		
		$.confirm({
			title: 'Account Delete Confirmation',
			content: 'Are you sure to delete '+Beneficiary_name+' account?',
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
							title: 'Account will be deleted.',
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
										
										$.ajax({
											
												type: "POST",
												data: { Beneficiary_account_id:Beneficiary_account_id},
												url: "<?php echo base_url()?>index.php/Beneficiary/Delete_Beneficiary_account",
												success: function(data)
												{
													//alert(data);
													if(data == 1)
													{
														var msg1 = 'Publisher Deleted Successfully..!!';
														$('#Beneficiary_div').show();
														$('#Beneficiary_div').css("color","green");
														$('#Beneficiary_div').html(msg1);
														setTimeout(function(){ $('#Beneficiary_div').hide(); }, 3000);
													   // $( "#Payment_card_no").focus();
													   // return false;
													}
													else
													{
														var msg1 = 'Error Deleting Publisher Account..!!';
														$('#Beneficiary_div').show();
														$('#Beneficiary_div').css("color","red");
														$('#Beneficiary_div').html(msg1);
														setTimeout(function(){ $('#Beneficiary_div').hide(); }, 3000);
													   // $( "#Payment_card_no").focus();
														//return false;
													}
												  
													location.reload(true);
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
				},
			}
		});
		
		
		
		
		
		
		
		
		
		
	}
</script>