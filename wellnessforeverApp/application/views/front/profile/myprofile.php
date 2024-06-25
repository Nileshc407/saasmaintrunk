<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu'); 

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}	
$Photograph = $Enroll_details->Photograph;
// echo"<br>----Photograph----".$Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}	
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button id="sidebarCollapse"><img src="<?php echo base_url(); ?>assets/img/menu.svg"></button></div>
				<div><h1><?php echo ucwords($Enroll_details->First_name); ?></h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
            <div class="col-12 proHomeWrapper">
                <div class="CurrPoints d-flex align-items-center">
                    <div class="pointIcon"><img src="<?php echo base_url(); ?>assets/img/current-points-icon.png"></div>
                    <div class="pointTxt">
                        <h2><?php echo $Current_point_balance; ?></h2>
                        <div class="txt"><?php echo $Company_Details->Currency_name; ?></div>
						<?php if($Enroll_details->Blocked_points > 0) { ?>
						<br>
						<div style="margin-left: -35%;"><strong><?php echo round($Enroll_details->Blocked_points); ?></strong> <?php echo $Company_Details->Currency_name.' ( blocked in Auction BID )'; ?></div>
                       <?php }  ?>
                    </div>
                </div>
                <ul class="profileMenu">
                    <li>
                        <a href="<?php echo base_url();?>index.php/Cust_home/profile" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/img/profile-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>Profile</h2>
									<!--<div class="brandTxt">Lorem Ipsum is simply dummy text</div>-->
								</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>index.php/Cust_home/transactions" class="cf w-100"> 
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/img/transactions-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>Transactions</h2>
									<!--<div class="brandTxt">Lorem Ipsum is simply dummy text</div>-->
								</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
		</div>
	</div>
</main>	
<?php $this->load->view('front/header/footer');  ?>