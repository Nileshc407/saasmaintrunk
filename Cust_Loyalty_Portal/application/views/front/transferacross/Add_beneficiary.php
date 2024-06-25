<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	
	//$Get_Beneficiary_Company="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Loyalty Programs</title>
    <?php $this->load->view('header/header'); ?>   
    <?php echo form_open_multipart('Beneficiary/Add_Beneficiary');?>
	<section class="content-header">
          <h1> Add Loyalty Programs </h1>         
	</section>
		
		
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
		
<section class="content">
	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
		</div>
	</div>
	<div id="content">		
			
		<div class="row products cd-container" id="FilterResult">		
		  <div id="Beneficiary_div" ></div>	
		
			<?php if(!empty($Get_Beneficiary_Company)) { ?>							
				
					<div class="row">
						<div class="col-md-1">			
						</div>			
						<div class="col-md-11 text-center">			
							<address>
								<p style="font-style:italic;text-align:left;color:#869791;font-size: 14px;line-height: 0px;">Note:</p>
								<p style="font-style:italic;text-align:left;color:#869791;font-size: 14px;line-height: 15px;">Click <b>'Enroll Now'</b> to become new member of that Organization. <br>
									Click <b>'+ Loyalty Program'</b> to link Membership of that Organization to Blendz.</p>
							</address>
						</div>
					</div>
				
				
			<?php } ?>
		
			<?php 
				if(!empty($Get_Beneficiary_Company)) {	
				 
					foreach($Get_Beneficiary_Company as $rec) {
					   
						$Company_details= $this->Igain_model->get_company_details($rec->Igain_company_id);	
						
						  if( $rec->Igain_company_id != 0 ){                                              
							  $Company_logo=$Company_details->Company_logo;                                              
						  } else {
							  $Company_logo=$rec->Company_logo;  
						  }
						 
					?>			
						
				<div class="col-md-3 ">
				<br>
					<div class="product" >
						<div class="image" style="height:150px;">
							<a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_details?Beneficiary_company_id=<?php echo $rec->Register_beneficiary_id.'*'.$rec->Igain_company_id; ?>">
								
								<img src="<?php echo $this->config->item('base_url2');?><?php echo $Company_logo;?>"  style="width: 66%;">
							</a>
						</div>
							
						<div class="text">
								<h5>
								<a href="#"><?php echo $rec->Beneficiary_company_name; ?> </a> </h5>
								
							<?php
							if (in_array($rec->Register_beneficiary_id, $Beneficiary_link_company_id)) {
						   ?>								
								<div class="text" style="height:53px;">
								</div>
								
							 <?php
							 } else {
								 ?>
									<div class="text">
										<button type="button" class="btn btn-template-main"  onclick="create_publisher_new_account(<?php echo $rec->Register_beneficiary_id; ?>,<?php echo $enroll; ?>,'<?php echo $rec->Beneficiary_company_name; ?>')" > <i class="fa fa-plus"></i> Enroll New
										</button>										
									</div>
								 <?php
							 }
							 ?>
							<div class="text">
								<button type="button" class="btn btn-template-main" onclick="add_loyalty_program(<?php echo $rec->Register_beneficiary_id?>,<?php echo $rec->Igain_company_id; ?>)" style="margin-left: -6px;">
									<i class="fa fa-plus"></i> Add Loyalty Program 
								</button>		
							</div>	
						</div>	
						<div id="new_account_<?php echo $rec->Register_beneficiary_id; ?>" style="text-align:center;"></div>
					</div>	
				</div>	
				
				 <?php             
				   }
					
				}
				else { ?>
						
					<div class="row">			
						<div class="login-box">
						  <div class="login-box-body">																					
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">													
										<li> 
											<button type="button" class="btn btn-template-main" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_Category'">No Records Found</button>
										</li>
									</ul>							  
								</div>
						  </div><!-- /.login-box-body -->
						</div><!-- /.login-box -->
						
					 </div><!-- /.row -->
					
				 <?php }
					?>
				
			</div>				
	</div>				
</section>

    <?php echo form_close(); ?>
    <?php $this->load->view('header/loader');?> 
    <?php $this->load->view('header/footer');?>	
        
<script>
function add_loyalty_program(Beneficiary_company_id,Igain_company_id) {
	
	 url="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_details?Beneficiary_company_id="+Beneficiary_company_id+"*"+Igain_company_id;
	window.location.href = url;

}
function create_publisher_new_account(PublisherID,enrollID,Beneficiary_company_name) {
      
	  // alert(PublisherID+'--enrollID-'+enrollID+'--Beneficiary_company_name--'+Beneficiary_company_name);
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
			
					BootstrapDialog.confirm('Your existing Enrollment details with '+Alise_name +' ( e.g. Name , Email id and Phone No.) will be used to enroll with the Publisher.<br>Are you okay?', function(result) 
					{
						
						if (result == true)
						{
							$.ajax({
								type: "POST",
								data:{ PublisherID:PublisherID , enrollID:enrollID},
								url: "<?php echo base_url()?>index.php/Transfer_publisher/create_publisher_new_account",
								dataType: "json", 
								success: function(json)
								{      

									var error = json['status'];
									// alert(error);
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
						}
						else
						{
							// alert('false');
							return false;
						}
					});

			}   
    }
</script>
<style>
	
	
	body{background: linear-gradient(to bottom right, #41c5a2, #c1c2e7);background-repeat: no-repeat;}	
	.btn 
	{
		color: #1fa07f;
		border-color: #1fa07f;
		background-color: #fff;
		padding: 7px;
		font-size: 12px;
		font-weight: bold;
		border-radius: 15px;
		/* width:100%; */
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