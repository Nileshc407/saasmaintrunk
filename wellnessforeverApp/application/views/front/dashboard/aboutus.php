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
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/set_brand?brndID=<?php echo $_SESSION['brndID']; ?>';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>About Us</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<div class="col-12 aboutWrapper">
				<?php if($_SESSION['brndID']== 382) { ?>
						<p>Java House, commonly referred to as ‘Nairobi Java’,opened its first store in 1999 at Adam’s Arcade in Nairobi. With the aim of introducing gourmet coffee drinking culture in Kenya, the first outlet was a coffee shop and later the brand evolved to an American diner style restaurant to its present-day status as a 3 -day part coffee-led, casual dining concept.</p>
						<p>Java House is now one of the leading coffee brands in Africa and has grown to have outlets in 14 cities across 3 countries in East Africa (Kenya, Uganda and Rwanda). It has also birthed two sister brands Planet Yoghurt, a healthy, tasty and fun frozen yoghurt store and 360 Degrees Pizza, a casual dining restaurant.</p>
						<p>“Welcome to Java. A home away from home”</p>
				<?php } else if($_SESSION['brndID']== 383) { ?>
					<p>Java House, commonly referred to as ‘Nairobi Java’,opened its first store in 1999 at Adam’s Arcade in Nairobi. With the aim of introducing gourmet coffee drinking culture in Kenya, the first outlet was a coffee shop and later the brand evolved to an American diner style restaurant to its present-day status as a 3 -day part coffee-led, casual dining concept.</p>				
						<p>Java House is now one of the leading coffee brands in Africa and has grown to have outlets in 14 cities across 3 countries in East Africa (Kenya, Uganda and Rwanda). It has also birthed two sister brands Planet Yoghurt, a healthy, tasty and fun frozen yoghurt store and 360 Degrees Pizza, a casual dining restaurant.</p>
						<p>“Welcome to Java. A home away from home”</p>
				<?php } else if($_SESSION['brndID']== 384) { ?>
					<p>Planet Yogurt believes in bringing friends and family together to enjoy the most natural &amp; fun frozen yogurt experience that promotes a healthy lifestyle. Planet Yogurt is the land of endless yogurt possibilities, where you're the boss, you rule the portions, choices and scene.</p>
				<?php } else if($_SESSION['brndID']== 385) { ?>
					<p>A warm welcome to you from 360 degrees Artisan Pizza. </p>
					<p>Named after the nature of our pizza which is cooked at above 360 degrees Celsius, we opened our doors in 2013 to offer a unique upscale casual dining experience.</p>
					<p>Our pizza pays homage to old world Vera Pizza Napolitano traditions, but is a contemporary take on the style. The pizza arrives still steaming from our Stefano Ferrara wood burning oven. The crust is thin, with a blistered cornicione—the raised rim of the pizza that’s the outer crust of the pizza — about an inch thick. It is neither thin and crispy nor thick and soft but chewy and crisp all at once. Because it is handcrafted, no two are exactly alike. The toppings are fresh and natural with each ingredient tasting very much like what it is. Our pizza strikes a careful balance among crust, sauce, and cheese with not too much of any one component.</p>
				<?php } else if($_SESSION['brndID']== 386) { ?>
                <p>
					Kukito is a uniquely Kenyan fast food brand, that offers healthy and tasty meals from a combination of simple ingredients. 
				</p>
				<?php } else if($_SESSION['brndID']== 932) { ?>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>				
				<?php } ?>
			</div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>
