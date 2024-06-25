<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');  
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Select Your Brand</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<div class="col-12 selectBrandWrapper">
				<?php if($brandDetails) { ?>
				<ul class="brandHldr">
					<?php foreach($brandDetails as $key => $value) { ?>
						<li>
							<a class="cf w-100"  href="<?php echo base_url(); ?>index.php/Cust_home/set_brand?brndID=<?php echo $value['Enrollement_id']; ?>">
								<div class="cardMain d-flex align-items-center">
									<div class="brandLogo"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $value['Enrollement_id'];?>/logo/logo.png"></div>
									<div class="titleTxtMain">
										<h2><?php echo $value['First_name'].' '.$value['Last_name'];?></h2>
										<div class="brandTxt"><?php echo $value['Label_1_value'];?></div>
									</div>
									<div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
								</div>
							</a>
						</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>
