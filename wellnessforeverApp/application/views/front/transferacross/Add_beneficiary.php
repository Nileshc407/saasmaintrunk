<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Loyalty Programs</title>
    <?php $this->load->view('front/header/header'); ?>   
    <?php echo form_open_multipart('Beneficiary/Add_Beneficiary');?>
<div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container">
            <div class="section-header">
               <p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_Category" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Add Loyalty Programs</p>
            </div>
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                    <!-- 1st Card -->
                  
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                    <div id="Beneficiary_div" ></div>	
                    
                        <?php if(!empty($Get_Beneficiary_Company)) { ?>							
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">			
                                        <address>
                                            <p style="font-style:italic;text-align:left;color:#869791;font-size: 11px;line-height: 0px;">Note:</p>
                                            <p style="font-style:italic;text-align:left;color:#869791;font-size: 11px;line-height: 15px;">Click <b>'Enroll Now'</b> to become new member of that Organization. <br>
                                                Click <b>'+ Loyalty Program'</b> to link Membership of that Organization to Blendz.</p>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php if(empty($Get_Beneficiary_Company)) { ?>							
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">			
                                        <address>
                                            <button type="button" id="button1" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_Category'">No Records Found</button>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                   
                    <div class="pricing-details">
			
						
                        <ul>
						
                                <?php 
                                
                                
                                //print_r($Beneficiary_link_company_id);
                               // print_r($Self_enroll_array);
                                 
                                if(!empty($Get_Beneficiary_Company)) {
                                  
                                   foreach($Get_Beneficiary_Company as $rec) {    
                                       
                                        $Company_details= $this->Igain_model->get_company_details($rec->Igain_company_id);
                                          
                                          if( $rec->Igain_company_id != 0 ){                                              
                                              $Company_logo=$Company_details->Company_logo;                                              
                                          } else {
                                              $Company_logo=$rec->Company_logo;  
                                          }
                                          
                                          // echo"--Self_enroll---".$rec->Self_enroll."--<br>";
                                            // echo"--Register_beneficiary_id---".$rec->Register_beneficiary_id."--<br>";
                                             //echo"--Enrollment_id---".$rec->Enrollment_id."--<br>";
                                          //echo"--enroll---".$enroll."--<br>";
                                         
                                    ?>
                                        <div class="row ">
                                           
                                                <li>
                                                    <?php /* ?>
                                                    <a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_details?Beneficiary_company_id=<?php echo $rec->Register_beneficiary_id.'*'.$rec->Igain_company_id; ?>">
                                                        <img src="<?php echo $this->config->item('base_url2');?><?php echo $Company_logo;?>" id="icon2"> &nbsp;&nbsp; <span id="Medium_font" style="width:50%"><?php echo $rec->Beneficiary_company_name; ?></span>						                                                   
                                                        <!--<img src="<?php //echo base_url(); ?>assets/icons/<?php //echo $icon_src1; ?>/right.png" id="icon" align="right"> -->
                                                    </a> 
                                                    <?php */ ?>
                                                     <img src="<?php echo $this->config->item('base_url2');?><?php echo $Company_logo;?>" id="icon2"> &nbsp;&nbsp; <span id="Medium_font" style="width:50%"><?php echo $rec->Beneficiary_company_name; ?></span>
                                                   <div class="row">                                          
                                                       
                                                       <?php
                                                        if (in_array($rec->Register_beneficiary_id, $Beneficiary_link_company_id)) {
                                                       ?>
                                                            
                                                             <div class="col-xs-6 text-right main-xs-6">

                                                            </div>
                                                         <?php
                                                         } 
                                                         else 
                                                             {
                                                             ?>
                                                                
                                                       
                                                                <div class="col-xs-6 text-right main-xs-6">
                                                                <button type="button" id="button" onclick="create_publisher_new_account(<?php echo $rec->Register_beneficiary_id; ?>,<?php echo $enroll; ?>,'<?php echo $rec->Beneficiary_company_name; ?>')" style="margin-left: -6px;">
                                                                    Enroll Now
                                                                </button>
                                                                <br>
                                                            </div>
                                                             <?php
                                                         }
                                                         ?>
                                                        <div class="col-xs-6 text-right main-xs-6">

                                                                <button type="button" id="button"  style="margin-left: -6px;"  >
                                                                    <a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_details?Beneficiary_company_id=<?php echo $rec->Register_beneficiary_id.'*'.$rec->Igain_company_id; ?>" id="button" style="border:none;">+ Loyalty Program</a>    
                                                                </button>
                                                                <br>

                                                        </div>                                                        
                                                    </div>
                                                    <div id="new_account_<?php echo $rec->Register_beneficiary_id; ?>" style="text-align:center;"></div>
                                                </li>
                                            
                                        </div>
                            
                                    
                            
                                    <?php
                                       
                                   
                                   }
                                    
                                }
                                    ?>
                        </ul>
                                        
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
    <?php echo form_close(); ?>
    <?php $this->load->view('front/header/footer');?>
        <link rel="stylesheet" type="text/css"  href="<?php echo base_url();?>assets/css/jquery-confirm.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.js"></script>
<script>
    
function create_publisher_new_account(PublisherID,enrollID,Beneficiary_company_name) {
      
        var Alise_name= '<?php echo $Company_Details->Alise_name; ?>';
      if(PublisherID == "" ){

            var msg1 = 'Invalid Publisher.';
            $('#new_account_'+PublisherID).show();
            $('#new_account_'+PublisherID).css('color','red');
            $('#new_account_'+PublisherID).html(msg1);
            setTimeout(function(){ $('#new_account_'+PublisherID).hide(); }, 3000);
            return false;
        }
        else if(enrollID == "" ){

            var msg1 = 'Invalid Identifier.';
            $('#new_account_'+PublisherID).show();
            $('#new_account_'+PublisherID).css('color','red');
            $('#new_account_'+PublisherID).html(msg1);
            setTimeout(function(){ $('#new_account_'+PublisherID).hide(); }, 3000);
            return false;
            
        } else {
                    $.confirm({
                    title: 'New Enrollment Confirmation!',
                    content: 'Your existing Enrollment details with '+Alise_name +' ( e.g. Name , Email id and Phone No.) will be used to enroll with the Publisher.<br><br> Are you okay?',
                    buttons: {
                        confirm: function () {


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
                                                    data:{ PublisherID:PublisherID , enrollID:enrollID},
                                                    url: "<?php echo base_url()?>index.php/Transfer_publisher/create_publisher_new_account",
                                                    dataType: "json", 
                                                    success: function(json)
                                                    {      

                                                        var error = json['status'];
                                                        //alert(error);
                                                        if(error==1001) {

                                                            $('#new_account_'+PublisherID).show();
                                                            $('#new_account_'+PublisherID).css('color','green');
                                                            $('#new_account_'+PublisherID).html('Enrollment Request success with '+Beneficiary_company_name);
                                                            setTimeout(function(){ $('#new_account_'+PublisherID).hide();
                                                                
                                                               location.reload();
                                                            
                                                            }, 3000);
                                                            return false;



                                                        } else {

                                                            $('#new_account_'+PublisherID).show();
                                                            $('#new_account_'+PublisherID).css('color','red');
                                                            $('#new_account_'+PublisherID).html(json['status_message']);
                                                            setTimeout(function(){ $('#new_account_'+PublisherID).hide(); 
                                                            
                                                            location.reload();
                                                            
                                                            }, 3000);
                                                            return false;
                                                        }

                                                    }
                                                }); 
           
                            },
                            cancel: function () {
                                //$.alert('Canceled!');
                            }
                        }
                    });

} 
    }
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
		/* padding: 12px 12px 0 12px; */
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{font-size: 13px;}
	
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
	
	#icon2{
	   width: 25%; 
	}
</style>
<?php
    if(@$this->session->flashdata('success'))
    {
        ?>
        <script>
                var msg1 = '<?php echo $this->session->flashdata('success'); ?>';
                // alert(msg);
                // var msg1 = 'Please enter all details..!!';
                $('#Beneficiary_div').show();
                $('#Beneficiary_div').css("color","<?php echo $Small_font_details[0]['Small_font_color']; ?>");
                $('#Beneficiary_div').css("font-family","<?php echo $Small_font_details[0]['Small_font_family']; ?>");
                $('#Beneficiary_div').css("font-size","<?php echo $Small_font_details[0]['Small_font_size']; ?>");
                $('#Beneficiary_div').css("padding-bottom","20px");
                $('#Beneficiary_div').html(msg1);
                setTimeout(function(){ $('#Beneficiary_div').hide(); }, 3000);
        </script>
        <?php
    }
?>