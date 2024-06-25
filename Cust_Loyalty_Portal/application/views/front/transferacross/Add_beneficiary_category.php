<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Loyalty Programs</title>
    <?php $this->load->view('header/header'); ?>   
    <?php echo form_open_multipart('Beneficiary/Add_Beneficiary');?>
	
	<section class="content-header">
	 <div class="row">			
		<div class="col-md-6">
			<h1> Add Loyalty Programs </h1>  
		</div>
		<div class="col-md-6">
			<address>
				<p style="font-style:italic;text-align:left;color:#a06316fa;font-size: 14px;line-height: 0px;">Note:</p>
				<p style="font-style:italic;text-align:left;color:#a06316fa;font-size: 14px;line-height: 15px;">Click <b>'Enroll Now'</b> to become new member of that Organization. <br>
					Click <b>'+ Loyalty Program'</b> to link Membership of that Organization to <?php echo $Company_Details->Company_name; ?>.</p>
			</address>
		</div>
	</div>
		  
			
	</section>   
	
	<section class="content">
        <div class="row">			
				<div class="col-md-6 bhoechie-tab-menu">
						<div class="list-group">
						<?php 
							if($Publishers_Category!=NULL)	
							{
								foreach($Publishers_Category as $Category)
								{								 
									$CategoryID=$Category->Code_decode_id;
									// echo"----Category-----".$Category[0][0]['Code_decode_id']."<br>";
									// echo"----Category-----".$Category[0][0]->Beneficiary_company_name."<br>";
									if($CategoryID==47)
									{
										$icon_name='air.png';
									}
									else if($CategoryID==48)
									{
										$icon_name='hospitality.png';
									}
									else if($CategoryID==49)
									{
										$icon_name='retail.png';
									}
									else if($CategoryID==50)
									{
										$icon_name='telecom.png';
									}
									else if($CategoryID==51)
									{
										$icon_name='car.png';
									}
									else
									{
									  $icon_name='';
									}
									
									
									?>								
									
										<a href="javascript:void(0);" onclick="add_category_publisher('<?php echo $CategoryID; ?>');" class="list-group-item text-center" >
											<img src="<?php echo base_url(); ?>images/<?php echo $icon_name;?>" > <br> <span id="Medium_font"><?php echo $Category->Code_decode; ?></span>
										</a>
										
									
									<?php 								
								}
							} 
						?>
						
					  </div>
				</div>
				
			
			<div class="col-lg-6" id="message2" style="overflow-y: scroll; height: 480px;">
						
			</div>
			
		</div><!-- /.row -->
		
	</section><!-- /.content -->
	
	
    <?php echo form_close(); ?>
    <?php $this->load->view('header/loader');?>
    <?php $this->load->view('header/footer');?>
	
	
<style>	
#icon{
	float: right;
	 width: 6%;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
	}
	
		
	
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #31859c;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #31859c;
  background-image: #31859c;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #31859c;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  /* padding-left: 20px;
  padding-top: 10px; */
  
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active) {
  display: none;
}
</style>
<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
<script>
function add_category_publisher(CategoryID){
	
	// alert(CategoryID);
	
	if( CategoryID > 0 )
	{		
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {CategoryID: CategoryID, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Beneficiary/add_category_publisher",
			success: function(data)
			{
				// $('#message2').html(data);
				
				$("#message2").html(data.CategoryPublisher);		
			}
		});
	}
}
</script>
<script>
    
	function create_publisher_new_account(PublisherID,enrollID,Beneficiary_company_name) {
	
	
        var Alise_name= '<?php echo $Company_Details->Alise_name; ?>';
		
		if(PublisherID == "" ){

            /* var msg1 = 'Invalid Publisher.';
            $('#new_account_'+PublisherID).show();
            $('#new_account_'+PublisherID).css('color','red');
            $('#new_account_'+PublisherID).html(msg1);
            setTimeout(function(){ $('#new_account_'+PublisherID).hide(); }, 3000); */
			
			var Title = "Application Information";
			var msg = 'Invalid Publisher';
			runjs(Title,msg);
			
            return false;
        }
        else if(enrollID == "" ){

            /* var msg1 = 'Invalid Identifier.';
            $('#new_account_'+PublisherID).show();
            $('#new_account_'+PublisherID).css('color','red');
            $('#new_account_'+PublisherID).html(msg1);
            setTimeout(function(){ $('#new_account_'+PublisherID).hide(); }, 3000); */
			
			var Title = "Application Information";
			var msg = 'Invalid Identifier';
			runjs(Title,msg);
			
            return false;
            
        } else {
			
			
				show_loader();
			
				$.ajax({
				type: "POST",
				data:{ PublisherID:PublisherID , enrollID:enrollID},
				url: "<?php echo base_url()?>index.php/Transfer_publisher/create_publisher_new_account",
				dataType: "json", 
				success: function(json)
				{      
					/*------------Hide Loader----------*/
						$('#myModal').toggle();
						$("#myModal").removeClass( "in" );
						$( ".modal-backdrop" ).remove();
					/*------------Hide Loader----------*/
					
					
					var error = json['status'];
					var message = json['status_message'];
					
					if(error == null || message == null ) {	
						/* $('#new_account_'+PublisherID).show();
						$('#new_account_'+PublisherID).css('color','green');
						$('#new_account_'+PublisherID).html('Enrollment Request success with '+Beneficiary_company_name);
						setTimeout(function(){ $('#new_account_'+PublisherID).hide(); */
						
						var Title = "Application Information";
						var msg = "Oops! something went wrong. We couldn't process your request.";
						runjs(Title,msg);
							
							
						// setTimeout(function(){ location.reload(); }, 3000);						
						
						
						// return false;
						
					} else if(error==1001) {
	
						/* $('#new_account_'+PublisherID).show();
						$('#new_account_'+PublisherID).css('color','green');
						$('#new_account_'+PublisherID).html('Enrollment Request success with '+Beneficiary_company_name);
						setTimeout(function(){ $('#new_account_'+PublisherID).hide(); */
						
						var Title = "Application Information";
						var msg = 'Enrollment Request success with '+Beneficiary_company_name;
						runjs(Title,msg);
							
							
						// setTimeout(function(){ location.reload(); }, 3000);						
						
						
						// return false;
						
					} else {

						/* $('#new_account_'+PublisherID).show();
						$('#new_account_'+PublisherID).css('color','red');
						$('#new_account_'+PublisherID).html(json['status_message']);
						setTimeout(function(){ $('#new_account_'+PublisherID).hide();  */
						
						var Title = "Application Information";
						var msg = json['status_message'];
						runjs(Title,msg);						
						
						// setTimeout(function(){ location.reload(); }, 3000);	
						
						
						
						// return false;
					}

				}
			}); 
           
                            
		}
	}
	
	function link_publisher_account(Register_beneficiary_id,Igain_company_id){
		
		var BeneficiaryCompany=Register_beneficiary_id+'*'+Igain_company_id;	
		
		if(BeneficiaryCompany == "" ){

            /* var msg1 = 'Invalid Publisher.';
            $('#new_account_'+PublisherID).show();
            $('#new_account_'+PublisherID).css('color','red');
            $('#new_account_'+PublisherID).html(msg1);
            setTimeout(function(){ $('#new_account_'+PublisherID).hide(); }, 3000); */
			
			var Title = "Application Information";
			var msg = 'Invalid Publisher';
			runjs(Title,msg);
			
            return false;
        }
         else {
			
			
				show_loader();
				
				
				window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_details/?Beneficiary_company_id='+BeneficiaryCompany;
			
				/* $.ajax({
				type: "POST",
				data:{ Beneficiary_company_id:BeneficiaryCompany},
				url: "<?php echo base_url()?>index.php/Beneficiary/Add_Beneficiary_details",
				dataType: "json", 
				success: function(json)
				{      

					var error = json['status'];
					var message = json['status_message'];
					
					//alert(message);
					
					if(error==1001) {
	
						var Title = "Application Information";
						var msg = 'Enrollment Request success with '+Beneficiary_company_name;
						runjs(Title,msg);
							
							
						setTimeout(function(){ location.reload(); }, 3000);						
						
						
						// return false;
						
					} else {

						var Title = "Application Information";
						var msg = json['status_message'];
						runjs(Title,msg);
						
						
						setTimeout(function(){ location.reload(); }, 3000);	
						
						
						
						// return false;
					}

				}
			});  */
           
                            
		}
		
		
		
		
		
	}
</script>