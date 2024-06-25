<?php 
$this->load->view('front/header/header');
// $this->load->view('front/header/menu'); 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/set_brand?brndID=<?php echo $_SESSION['brndID']; ?>';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Contact Us</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop1 padBottom">
	<div class="container">
		<div class="row">
            <div class="col-12 contactImg px-0">
                <img src="<?php echo base_url(); ?>assets/img/contact.jpg">
            </div>
			<div class="col-12 contactWrapper">
                <div class="row">
                    <div class="col-6 pr-2">
                        <a class="cf w-100" href="tel:971 719 547940<?php //echo $Phone_no;  ?>">
                            <div class="cardMain text-center">
                                <i class="icon"><img src="<?php echo base_url(); ?>assets/img/call-us-icon.svg"></i>
                                <h2 class="titleTxt orangeTxt">Call Us</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 pl-2">
                        <a class="cf w-100" href="mailto:Guest.relations@digicoffeehouse.ae<?php //echo $User_email_id;  ?>">
                            <div class="cardMain text-center">
                                <i class="icon"><img src="<?php echo base_url(); ?>assets/img/email-us-icon.svg"></i>
                                <h2 class="titleTxt greenTxt">Email Us</h2>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="col-4 pl-2">
                        <a class="cf w-100" href="#">
                            <div class="cardMain text-center">
                                <i class="icon"><img src="img/chat-icon.svg"></i>
                                <h2 class="titleTxt purpalTxt">Chat</h2>
                            </div>
                        </a>
                    </div> -->
                </div>
			</div>
            <div class="col-12 contactWrapper">
                <div class="cardMain mb-4 p-3">
                    <p><i class="mr-2"><img src="<?php echo base_url(); ?>assets/img/phone-icon.svg"></i> +971 999 999999<?php /* echo substr($Phone_no, 0, 3).' '.substr($Phone_no, 3, 2).' '.substr($Phone_no,5,2).' '.substr($Phone_no,7,2).' '.substr($Phone_no,9,2);  */ ?></p>
                    <p><i class="mr-2"><img src="<?php echo base_url(); ?>assets/img/phone-icon.svg"></i> +971 990 999999<?php /* echo substr($Phone_no, 0, 3).' '.substr($Phone_no, 3, 2).' '.substr($Phone_no,5,2).' '.substr($Phone_no,7,2).' '.substr($Phone_no,9,2);  */ ?></p>
                    <p><i class="mr-2"><img src="<?php echo base_url(); ?>assets/img/email-icon.svg"></i>Guest.relations@digicoffeehouse.ae<?php /* echo $User_email_id; */  ?></p>
                </div>
				<?php
				if(@$this->session->flashdata('error_code'))
				{
					?>
						
						
						<div class="alert alert-success alert-dismissible">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong>Success!</strong> <?php echo $this->session->flashdata('error_code'); ?>.
						</div>
						
					<?php
				}
					
				?>
                <h2>Quick Contact</h2>
                <form  name="TransferPoint" method="POST" action="<?php echo base_url()?>index.php/Cust_home/contactus_App" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label class="font-weight-bold">Message</label>
                        <textarea class="form-control" rows="3" name="offerdetails" id="message_detail"placeholder="Enter message" required></textarea>
                    </div>
                    <!--<a href="#" class="redBtn w-100 text-center">Submit</a>-->
					<input type="hidden" name="contact_subject" value="1">	
					
					<button type="submit" class="redBtn w-100 text-center" value="submit" name="submit">Submit</button>
                </form>
            </div>
            <div class="col-12 contactWrapper text-center">
                <ul class="socialIcon">
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/img/facebook.svg"></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/img/twitter.svg"></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/img/instagram.svg"></a></li>
                </ul>
            </div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>	
