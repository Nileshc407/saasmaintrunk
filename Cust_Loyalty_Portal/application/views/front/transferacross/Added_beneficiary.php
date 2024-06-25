<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	
	
		// $Get_Beneficiary_members="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Loyalty Programs</title>
    <?php $this->load->view('header/header'); ?>   
    
	
		<?php if(empty($Get_Beneficiary_members)) { ?>
							
				 <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">My Active Loyalty Programs</h3>                 
					</div>
						<div class="row">
							<div class="col-md-12">			
								<address class="text-center">
									<button type="button" id="button" class="btn btn-template-main" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary'">No Accounts Found</button>
								</address>
							</div>
						</div>
					</div>                         

		<?php } ?>
  <?php if(!empty($Get_Beneficiary_members)) { ?>
   <div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title">My Active Loyalty Programs</h3>                 
		</div>         		
		<div class="row">
			
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
				
					
			<div class="col-md-3">
				<div class="box box-primary" >
					<div class="box-body box-profile">		
						<div class="text-center" style="min-height:120px;">
							<img class="img-fluid" src="<?php echo $this->config->item('base_url2');?><?php echo $Rec2->Company_logo; ?>" id="no_image" alt="Member profile picture" style="width:50%;">				
						</div>						
						<h3 class="profile-username text-center"><?php echo $Rec2->Beneficiary_company_name ?></h3>
						
						<ul class="list-group list-group-unbordered">
							
							
							<li class="list-group-item">
								<b>Name </b> <a class="pull-right"><?php echo $Rec2->Beneficiary_name; ?></a>
							</li>
							<li class="list-group-item">
								<b>Identifier</b> <a class="pull-right"><?php echo $Rec2->Beneficiary_membership_id; ?></a>
							</li>
							
							<li class="list-group-item">
								<a href="javascript:void(0);" onclick="remove_beneficiary(<?php echo $Rec2->Beneficiary_account_id; ?>,'<?php echo $Rec2->Beneficiary_name; ?>');"> <img src="<?php echo base_url(); ?>images/remove.png" alt="" class="img-rounded img-responsive" width="30">  </a> 
								<span class="pull-right">
								<img src="<?php echo base_url(); ?>images/<?php echo $img_name; ?>" alt="" class="img-rounded img-responsive" width="100" style="margin-top:-35px;"> </span>
							</li>
																			
						</ul>
					</div>
				</div>
             
            </div>
     
			<?php								
			}		
		?>
		<div id="Beneficiary_div" class="text-center" ></div>
		</div>		
	</div>	
	<?php } ?>
	
	
	
	<?php if(!empty($Get_Beneficiary_inactive_account)) { ?>
   <div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title">My Inactive Loyalty Programs</h3>                 
		</div>         		
		<div class="row">
			
			<?php     
				
				foreach($Get_Beneficiary_inactive_account as $Rec3) {
				   // echo"---Igain_company_id----".$Rec2->Igain_company_id."--<br>";
					$Company_details= $this->Igain_model->get_company_details($Rec3->Igain_company_id);
			   
				if($Rec3->Beneficiary_status==0) {
						$Beneficiary_status='Pending';
						 $img_name='pending.png';
				}
				if($Rec3->Beneficiary_status==1) {
						$Beneficiary_status='Approved';
						 $img_name='approved.png';
				}
				if($Rec3->Beneficiary_status==2) {
						$Beneficiary_status='Not Approved';
						$img_name='declined.png';
				}
				?>
				
					
			<div class="col-md-3">
				<div class="box box-primary" >
					<div class="box-body box-profile">		
						<div class="text-center" style="min-height:120px;">
							<img class="img-fluid" src="<?php echo $this->config->item('base_url2');?><?php echo $Rec3->Company_logo; ?>" id="no_image" alt="Member profile picture" style="width:50%;">				
						</div>						
						<h3 class="profile-username text-center"><?php echo $Rec3->Beneficiary_company_name ?></h3>
						
						<ul class="list-group list-group-unbordered">
							
							
							<li class="list-group-item">
								<b>Name </b> <a class="pull-right"><?php echo $Rec3->Beneficiary_name; ?></a>
							</li>
							<li class="list-group-item">
								<b>Identifier</b> <a class="pull-right"><?php echo $Rec3->Beneficiary_membership_id; ?></a>
							</li>
							
							<li class="list-group-item">
								<a href="javascript:void(0);" onclick="activate_beneficiary_account(<?php echo $Rec3->Beneficiary_account_id; ?>,'<?php echo $Rec3->Beneficiary_name; ?>');"> <img src="<?php echo base_url(); ?>images/activate.png" alt="" class="img-rounded img-responsive" width="100">  </a> 
								<span class="pull-right">
								<img src="<?php echo base_url(); ?>images/<?php echo $img_name; ?>" alt="" class="img-rounded img-responsive" width="100" style="margin-top:-40px;" > </span>
							</li>
																			
						</ul>
					</div>
				</div>
             
            </div>
     
			<?php								
			}		
		?>
		<div id="Beneficiary_div" class="text-center" ></div>
		</div>		
	</div>	
	<?php } ?>
	
	
	<?php $this->load->view('header/loader');?> 
    <?php $this->load->view('header/footer');?>
	


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
		BootstrapDialog.confirm("Do you want to delete <b>" + Beneficiary_name + "</b>'s Publisher Account", function(result){

		if (result == true){
			show_loader();
										
			$.ajax({
				
					type: "POST",
					data: { Beneficiary_account_id:Beneficiary_account_id},
					url: "<?php echo base_url()?>index.php/Beneficiary/Delete_Beneficiary_account",
					success: function(data)
					{
						$('#myModal').toggle();
						$("#myModal").removeClass( "in" );
						$( ".modal-backdrop" ).remove();
						
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
		else
		{
			return false;
		}
			
		});
		
	}
	function activate_beneficiary_account(Beneficiary_account_id,Beneficiary_name)
	{
		BootstrapDialog.confirm("Do you want to activate <b>" + Beneficiary_name + "</b>'s Publisher Account", function(result){
		
		if (result == true) {
			show_loader();
										
			$.ajax({
				
					type: "POST",
					data: { Beneficiary_account_id:Beneficiary_account_id},
					url: "<?php echo base_url()?>index.php/Beneficiary/activate_Beneficiary_account",
					success: function(data)
					{
						$('#myModal').toggle();
						$("#myModal").removeClass( "in" );
						$( ".modal-backdrop" ).remove();
						
						if(data == 1)
						{
							var msg1 = 'Publisher Activated Successfully..!!';
							$('#Beneficiary_div').show();
							$('#Beneficiary_div').css("color","green");
							$('#Beneficiary_div').html(msg1);
							setTimeout(function(){ $('#Beneficiary_div').hide(); }, 3000);
						   // $( "#Payment_card_no").focus();
						   // return false;
						}
						else
						{
							var msg1 = 'Error Activating Publisher Account..!!';
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
		else
		{
			return false;
		}
			
		});
		
	}
</script>