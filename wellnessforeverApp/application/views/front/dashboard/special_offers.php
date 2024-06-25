<?php $this->load->view('front/header/header'); ?>

<?php
	$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
	if($Current_point_balance<0){
		$Current_point_balance=0;
	}else{
		$Current_point_balance=$Current_point_balance;
	}
	
?>
	
		
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/set_brand?brndID=<?php echo $_SESSION['brndID']; ?>';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Special Offers</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
			
				
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<div class="col-12 specialOfferWrapper">
				<ul class="offerHldr">
					<?php 
					
					$flag=0;
						$dir = base_url()."assets/brand-".$_SESSION['brndID']."/offer/";
						
						$dir1 = $_SERVER["DOCUMENT_ROOT"].'/'.$this->config->item('base_url_folder').'/assets/brand-'.$_SESSION['brndID'].'/offer/';
						
						$file_display = array('jpg', 'jpeg', 'png', 'gif');
						 // echo "dir1---".$dir1."-----<br>";
						if ( file_exists( $dir1 ) == false ) {
						   
						   // echo 'Directory \'', $dir, '\' not found!';
						   echo '<p style="text-align:center">No Offers found!</p>';
						   
						} else {
						   $dir_contents = scandir( $dir1 );
						   
						   // print_r($dir_contents);
						   
							if($dir_contents){
								
								foreach ( $dir_contents as $file ) {
								   $file_type = strtolower( end( explode('.', $file ) ) );
								   // echo "dir---".$dir."---- file---".$file."----- file_type---".$file_type."------<br>";
								   if($file_type != "" && $file != "" ){
									   
									   if ( ($file !== '.') && ($file !== '..') && (in_array( $file_type, $file_display)) ) {
										  echo '<li><a href="#"><img src="'.$dir . '/' . $file, '" alt="', $file, '"/></a></li>';
											// break;
											
											$flag +=1;
											
									   }
									   
								   } else {
									   
									   $flag=0;
									    // echo '<p style="text-align:center">No Offers found!</p>';
										  // break;
								   }
								   
								}	
							} else {
								
								 echo '<p style="text-align:center">No Offers found!</p>';
							}
							
						}
						
						 // echo "flag---".$flag."-----<br>";
						 if($flag==0){
							  echo '<p style="text-align:center">No Offers found!</p>';
						 }
						 
						 
						?>
                    <!--<li><a href="#"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/offer1.jpg"></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/offer2.jpg"></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/offer3.jpg"></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/offer4.jpg"></a></li>-->
                    
                </ul>
			</div>
		</div>
	</div>
</main>				
					
				
				
					
		

<?php $this->load->view('front/header/footer');  ?>