<?php  $this->load->view('front/header/header');  
$this->load->view('front/header/menu');  ?>
<header>
	<div class="container">
		<div class="d-flex align-items-center">
			<button class="toggle-menu">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<div class="only-link">
			<a href="#"><span></span></a>
			</div>
		</div>
	</div>
</header>
	<br><br><br>
	<div class="custom-body">
		<?php echo $Notifications->Offer_description; ?>
	</div>
<?php $this->load->view('front/header/footer'); ?>