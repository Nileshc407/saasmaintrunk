<?php
   defined('BASEPATH') OR exit('No direct script access allowed'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }   
   //echo"---To_Beneficiary_company_id---to-beneficiary----".$To_Beneficiary_company_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>To Beneficiary</title>
    <?php $this->load->view('front/header/header'); ?>  
    
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
        <div class="container">
            <div class="section-header">
                <p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/left.png" id="arrow"></a></p>
                <p id="Extra_large_font">From <?php echo $Company_Details->Alise_name; ?></p>
            </div>
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                    <!-- 1st Card -->
                <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <?php if($Company_name) { ?> 
                        <div class="pricing-details">
                           
                                
                                         <a href="<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer_Third?Beneficiary_company_id=<?php echo $Company_id; ?>&To_Beneficiary_company_id=<?php echo $To_Beneficiary_company_id; ?>&To_others=0">
                                            <div class="row">
                                                <div class="col-xs-4 text-center"  style="width: 30%;">
                                                    <img src="<?php echo $this->config->item('base_url2');?><?php echo $Company_logo; ?>" alt="" class="img-rounded img-responsive" width="80"><br>
                                                </div>
                                                <div class="col-xs-8 text-left" style="width: 60%;">
                                                    <span id="Small_font"><?php echo $Company_name; ?></span><br>
                                                    <span id="Small_font">Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span id="Value_font"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></span><br>
                                                    <span id="Small_font">Identifier&nbsp;:</span>  <span id="Value_font"><?php echo $Membership_id; ?></span><br>
                                                </div>
                                                <div class="col-xs-2"  style="width: 5%;margin-top: 25px;">                                                        
                                                    <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/right.png" alt="" class="img-rounded img-responsive" width="20">
                                                </div>
                                            </div>
                                        </a>
                        </div>
                        <hr>
                        <?php
                        }
                        ?>     
                        <?php 
                           
                            if($Get_Beneficiary_Company) {                                       
                            foreach($Get_Beneficiary_Company as $rec) { 
                                if($rec->Register_beneficiary_id != $To_Beneficiary_company_id) {
                                $Company_details= $this->Igain_model->get_company_details($rec->Igain_company_id);
                                $Get_Beneficiary_members= $this->Beneficiary_model->Get_Beneficiary_members_2($rec->Register_beneficiary_id,$enroll);                    
                                foreach($Get_Beneficiary_members as $Membership_id)
                                {
                                   $Beneficiary_membership_id =$Membership_id->Beneficiary_membership_id;                   
                                }
                                $Get_Beneficiary_members_details= $this->Igain_model->get_customer_details($Beneficiary_membership_id,$rec->Igain_company_id);           
                                ?> 
                                <div class="pricing-details">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- 1 -->    
                                           
                                            
                                            <a href="<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer_Third?Beneficiary_company_id=<?php echo $rec->Register_beneficiary_id; ?>&To_Beneficiary_company_id=<?php echo $To_Beneficiary_company_id; ?>&To_others=1">
                                            <div class="row">
                                                <div class="col-xs-4 text-center"  style="width: 30%;">
                                                    <img src="<?php echo $this->config->item('base_url2');?><?php echo $Company_details->Company_logo; ?>" alt="" class="img-rounded img-responsive" width="80"><br>
                                                </div>
                                                <div class="col-xs-8 text-left" style="width: 60%;">
                                                    <span id="Small_font"><?php echo $rec->Beneficiary_company_name; ?></span><br>
                                                    <span id="Small_font">Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span id="Value_font"><?php echo $Get_Beneficiary_members_details->First_name.' '.$Get_Beneficiary_members_details->Last_name; ?></span><br>
                                                    <span id="Small_font">Identifier&nbsp;:</span>  <span id="Value_font"><?php echo $Get_Beneficiary_members_details->Card_id;; ?></span><br>
                                                </div>
                                                <div class="col-xs-2"  style="width: 5%;margin-top: 25px;">                                                        
                                                    <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/right.png" alt="" class="img-rounded img-responsive" width="20">
                                                </div>
                                            </div>
                                            </a>
                                            <hr style="background:#ffffff;">
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                 <?php	
                                }
                            }
                        }
                        ?>
                    <br>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="row" id="Footer_font">
            <div class="col-xs-3 footer-xs">
                <a href="<?php echo base_url(); ?>index.php/Cust_home/home"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/home.png" alt="" class="img-rounded img-responsive" width="15"><br />
                    <span id="foot_txt">Home</span>
                </a>
            </div>			
            <div class="col-xs-3 footer-xs">
                <a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary">				
                    <div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/beneficiary.png" alt="" class="img-rounded img-responsive" width="15">  </div>
                    <span id="foot_txt">(+)Beneficiary</span>				
                </a>
            </div>
            <div class="col-xs-3 footer-xs">
                 <a href="<?php echo base_url()?>index.php/Beneficiary/Beneficiary_Points_Transfer_History">
                    <div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/transactions.png" alt="" class="img-rounded img-responsive" width="15">  </div>				 
                    <span id="foot_txt">Transactions</span>
                </a>
            </div>
        </div>
    </div>
 
<?php $this->load->view('front/header/footer');?>

<style>
    #icon{
		float: right;
		 width: 50%;
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
	
	.footer-card-span {

		color: #000 !important;
		font-size: 12px !important;
		text-transform: uppercase;
		display: inline;
	}
	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
		line-height: 10px;
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