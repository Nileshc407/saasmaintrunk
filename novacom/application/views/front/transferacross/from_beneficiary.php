<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>From Publisher</title>
    <?php $this->load->view('header/header'); ?>  
    <section class="content-header">
		<h1>Select Publisher</h1>         
	</section> 
		<br>
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container">
            <div class="section-header">
              
                <p id="Extra_large_font"> Select Publisher</p>
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
                                            <button type="button" id="button1" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Load_beneficiary'">No Records Found</button>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- 1 -->
                                        <?php if($Get_Beneficiary_members) {                                       
                                            foreach($Get_Beneficiary_members as $Rec2) { 
                                                //echo"---Igain_company_id---". $Rec2->Igain_company_id."--<br>";
                                               $Company_details= $this->Igain_model->get_company_details($Rec2->Igain_company_id);
                                               if($Rec2->Beneficiary_status==1) { 
                                                ?> 
                                                <a href="<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer_Second?To_Beneficiary_company_id=<?php echo $Rec2->Beneficiary_company_id; ?>&Beneficiary_membership_id=<?php echo $Rec2->Beneficiary_membership_id; ?>">  
                                                    <div class="row">
                                                        <div class="col-xs-4 text-center"  style="width: 30%;">
                                                            <img src="<?php echo $this->config->item('base_url2');?><?php echo $Rec2->Company_logo; ?>" alt="" class="img-rounded img-responsive" width="80"><br>
                                                        </div>
                                                        <div class="col-xs-8 text-left" style="width: 60%;">
                                                            <span id="Small_font"><?php echo $Rec2->Beneficiary_company_name ?></span><br>
                                                            <span id="Small_font">Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span id="Value_font"><?php echo $Rec2->Beneficiary_name; ?></span><br>
                                                            <span id="Small_font">Identifier&nbsp;:</span>  <span id="Value_font"><?php echo $Rec2->Beneficiary_membership_id; ?></span><br>
                                                        </div>
                                                        <div class="col-xs-2"  style="width: 5%;margin-top: 25px;">                                                        
                                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" alt="" class="img-rounded img-responsive" width="15" >
                                                        </div>
                                                    </div>
                                                </a>
                                                <hr>
                                                 
                                            <?php	
                                               }
                                        }
                                    }
									
									
                                    ?>
                                   			
                                </div>
                            </div>
                        </div>
                    <br>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
     
<?php $this->load->view('header/footer');?>
<style>
#icon
{
	float: right;
	 width: 6%;
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
	address{
		font-size: 13px;
	}
	
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
	}
	
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
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}		
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 5% 0 0 0;
		outline: none;
	}
	
	#desc1{
		width:100%;
	}
	
	#button{
		border: 1px solid #1fa07f;
		padding: 0 3%;
		border-radius: 15px;
		margin: 8% 1%;
		color: #1fa07f;
	}
	
	/* Search Bar Css */
	.txt{
		border: none;
		padding: 1% 0 0 0;
		width:56%;
		outline: none;
		background: none;
		margin-left: 16%;
		color: #1fa07f;
		height: 35px;
	}
	
	#search{
		font-size:20px;
		margin-left: 6%;
		color: #1fa07f;
		
	}
	::placeholder {
	color: gray;
	}
	
	#address{
		border: 1px solid #1fa07f;
		padding: 0;
		border-radius: 50px;
		margin: 8% 8%;
		color: #1fa07f;
	}
	/* Search Bar Css Ended*/
	
	#button {
		border: 1px solid #1fa07f;
		padding: 1% 9%;
		border-radius: 15px;
		margin: 8% 4%;
		color: #1fa07f;
	}
</style>