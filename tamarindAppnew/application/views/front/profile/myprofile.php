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
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}	
?>
	
		<!--<header>
            <div class="container">
               <div class="d-flex align-items-center">
                  <div class="only-link" style="width: 100%; position: absolute; top: 10px; left: 0; z-index: -1;">
                     <a href="#"><span>Profile</span></a>
                     </div>
               </div>
            </div>
		 </header>-->
		 
		  <div class="custom-body">
			<form  name="Update_profile" id="myForm" method="POST" action="<?php echo base_url()?>index.php/Cust_home/Update_img" enctype="multipart/form-data" onsubmit="return form_submit();">	
            <div class="container">
               <div class="profile-box">
			    <!--<a href="<?php echo base_url();?>index.php/Cust_home/Upload_img">-->
                  <div class="avtar" id="profile_pic">
                     <img src="<?php echo $Photograph; ?>" id="image2"  alt=""/>
                  </div>
				<!-- </a>-->
				<div class="upload_btn_set">
					<div class="upload_btn">
					<i class="fa fa-pencil-square-o" aria-hidden="true" style="color: white;">
						<input type="file" name="image1" id="image1" onchange="readImage(this,'#image2');" required />
					</i>
						<!--<span class="btn btn-primary">Upload Photo</span>-->
					</div>
				</div>
				
                  <h2><?php echo ucwords($Enroll_details->First_name).' '.ucwords($Enroll_details->Last_name); ?></h2>
                  <!-- <h4>Silver Member</h4> -->
                  <div class="point">
                     <span><?php echo $Current_point_balance; ?> <?php echo $Company_Details->Currency_name; ?></span>
                  </div>
               </div>
            </div>
			</form>
            <div class="main-nav">
			<?php
				if(@$this->session->flashdata('error_code'))
				{
				?>
					<div class="alert bg-warning alert-dismissible" id="msgBox" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
					</div>
				<?php
				} ?>
               <ul>
                  <li class="parent-item">
                     <a href="<?php echo base_url();?>index.php/Cust_home/profile" <?php if($page==1){ ?> class="active" <?php } ?>">
                        <span class="icon">
                           <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect width="38" height="38" fill="#E1A8AA"/>
                              <path d="M11.8827 26.8664C11.7397 26.6638 11.71 26.412 11.8045 26.1722C12.9983 23.2821 15.8503 21.399 19.061 21.399C22.2677 21.399 25.1245 23.2788 26.3728 26.1765C26.4653 26.4151 26.4351 26.6651 26.2929 26.8664L26.8006 27.2248L26.2929 26.8664C26.1473 27.0727 25.9004 27.2008 25.6205 27.2008H12.5551C12.2555 27.2008 12.0322 27.0783 11.8827 26.8664Z" stroke="#302F64" stroke-width="1.5"/>
                              <path d="M19.0611 11.75C21.0217 11.75 22.5949 13.3103 22.5949 15.1725C22.5949 17.0347 21.0217 18.595 19.0611 18.595C17.1005 18.595 15.5273 17.0347 15.5273 15.1725C15.5273 13.3103 17.1005 11.75 19.0611 11.75Z" stroke="#302F64" stroke-width="1.5"/>
                           </svg>
                        </span>
                        Profile Details
                     </a>
                  </li>
                  <li class="parent-item">
                     <a href="<?php echo base_url();?>index.php/Cust_home/profile_address" <?php if($page==2){ ?> class="active" <?php } ?>">
                        <span class="icon">
                           <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect width="38" height="38" rx="10" fill="#F8E0A4"/>
                              <path d="M19.1329 28.0717L24.5754 18.9846L19.1329 28.0717ZM19.1329 28.0717L13.548 19.0718L19.1329 28.0717ZM12.5778 15.6822C12.5778 16.8834 12.9187 18.0555 13.548 19.0717L12.5778 15.6822ZM12.5778 15.6822C12.5778 12.1265 15.4795 9.22474 19.0352 9.22474M12.5778 15.6822L19.0352 9.22474M19.0352 9.22474C22.5909 9.22474 25.4883 12.1264 25.4883 15.6822M19.0352 9.22474L25.4883 15.6822M25.4883 15.6822C25.4883 16.848 25.1697 17.9901 24.5755 18.9845L25.4883 15.6822ZM12.2648 19.8672L12.2648 19.8672L18.5029 29.9198C18.6407 30.1418 18.8833 30.2767 19.1443 30.2767H19.1443H19.1444H19.1444H19.1444H19.1444H19.1444H19.1445H19.1445H19.1445H19.1445H19.1445H19.1446H19.1446H19.1446H19.1446H19.1446H19.1447H19.1447H19.1447H19.1447H19.1447H19.1448H19.1448H19.1448H19.1448H19.1448H19.1449H19.1449H19.1449H19.1449H19.1449H19.145H19.145H19.145H19.145H19.145H19.1451H19.1451H19.1451H19.1451H19.1452H19.1452H19.1452H19.1452H19.1452H19.1453H19.1453H19.1453H19.1453H19.1453H19.1454H19.1454H19.1454H19.1454H19.1454H19.1455H19.1455H19.1455H19.1455H19.1455H19.1456H19.1456H19.1456H19.1456H19.1456H19.1457H19.1457H19.1457H19.1457H19.1457H19.1458H19.1458H19.1458H19.1458H19.1458H19.1459H19.1459H19.1459H19.1459H19.1459H19.146H19.146H19.146H19.146H19.146H19.1461H19.1461H19.1461H19.1461H19.1461H19.1462H19.1462H19.1462H19.1462H19.1462H19.1463H19.1463H19.1463H19.1463H19.1463H19.1464H19.1464H19.1464H19.1464H19.1464H19.1465H19.1465H19.1465H19.1465H19.1465H19.1466H19.1466H19.1466H19.1466H19.1466H19.1467H19.1467H19.1467H19.1467H19.1468H19.1468H19.1468H19.1468H19.1468H19.1469H19.1469H19.1469H19.1469H19.1469H19.147H19.147H19.147H19.147H19.147H19.1471H19.1471H19.1471H19.1471H19.1471H19.1472H19.1472H19.1472H19.1472H19.1472H19.1473H19.1473H19.1473H19.1473H19.1473H19.1474H19.1474H19.1474H19.1474H19.1474H19.1475H19.1475H19.1475H19.1475H19.1475H19.1476H19.1476H19.1476H19.1476H19.1476H19.1477H19.1477H19.1477H19.1477H19.1477H19.1478H19.1478H19.1478H19.1478H19.1478H19.1479H19.1479H19.1479H19.1479H19.1479H19.148H19.148H19.148H19.148H19.148H19.1481H19.1481H19.1481H19.1481H19.1481H19.1482H19.1482H19.1482H19.1482H19.1482H19.1483H19.1483H19.1483H19.1483H19.1483H19.1484H19.1484H19.1484H19.1484H19.1485H19.1485H19.1485H19.1485H19.1485H19.1486H19.1486H19.1486H19.1486H19.1486H19.1487H19.1487H19.1487H19.1487H19.1487H19.1488H19.1488H19.1488H19.1488H19.1488H19.1489H19.1489H19.1489H19.1489H19.1489H19.149H19.149H19.149H19.149H19.149H19.1491H19.1491H19.1491H19.1491H19.1491H19.1492H19.1492H19.1492H19.1492H19.1492H19.1493H19.1493H19.1493H19.1493H19.1493H19.1494H19.1494H19.1494H19.1494H19.1494H19.1495H19.1495L19.1495 30.2767L19.1503 30.2767C19.4135 30.2746 19.6567 30.1356 19.7919 29.9097L25.871 19.7597L25.8711 19.7596C26.6055 18.5307 26.9937 17.1207 26.9937 15.6822C26.9937 11.2938 23.4236 7.72373 19.0352 7.72373C14.6468 7.72373 11.0768 11.2938 11.0768 15.6822C11.0768 17.1647 11.4874 18.6117 12.2648 19.8672Z" fill="#302F64" stroke="#302F64" stroke-width="0.2"/>
                              <path d="M19.0357 11.6529C16.8139 11.6529 15.0064 13.4604 15.0064 15.6822C15.0064 17.8894 16.7845 19.7114 19.0357 19.7114C21.3148 19.7114 23.0649 17.8649 23.0649 15.6822C23.0649 13.4604 21.2575 11.6529 19.0357 11.6529ZM19.0357 18.2104C17.6391 18.2104 16.5075 17.075 16.5075 15.6822C16.5075 14.293 17.6465 13.1539 19.0357 13.1539C20.4246 13.1539 21.5595 14.2928 21.5595 15.6822C21.5595 17.0552 20.454 18.2104 19.0357 18.2104Z" fill="#302F64" stroke="#302F64" stroke-width="0.2"/>
                           </svg>
                        </span>
                        Address Details
                     </a>
                  </li>
                  <li class="parent-item">
                     <a href="<?php echo base_url();?>index.php/Cust_home/changepassword" <?php if($page==3){ ?> class="active" <?php } ?>">
                        <span class="icon">
                           <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect width="38" height="38" rx="10" fill="#3C46C1" fill-opacity="0.4"/>
                              <path d="M26.8227 26.1644C26.8227 27.252 25.9411 28.1332 24.8538 28.1332H13.1528C12.0658 28.1332 11.1846 27.2516 11.1846 26.1644V18.2527C11.1846 17.1655 12.0658 16.2842 13.1528 16.2842H24.8538C25.9411 16.2842 26.8227 17.1655 26.8227 18.2527V26.1644Z" stroke="#302F64" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M14.6768 15.6741V13.799C14.6768 13.799 14.6768 9.39627 19.0127 9.40301C19.0127 9.40301 23.1962 9.02946 23.3281 13.7336V15.6741" stroke="#302F64" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M19.0046 25.246C19.7039 25.246 20.2709 24.679 20.2709 23.9797C20.2709 23.2803 19.7039 22.7134 19.0046 22.7134C18.3052 22.7134 17.7383 23.2803 17.7383 23.9797C17.7383 24.679 18.3052 25.246 19.0046 25.246Z" fill="#302F64"/>
                              <path d="M19.0092 20.1602L18.998 23.1078" stroke="#302F64" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>
                        </span>
                        Change Password
                     </a>
                  </li>
				   <li class="parent-item">
                     <a href="<?php echo base_url(); ?>index.php/Cust_home/signout">
                        <span class="icon">
                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="38" height="38" viewBox="0 0 38 38">
							  <image id="signout" width="38" height="38" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAmCAYAAACoPemuAAAB/0lEQVRYhWO8/fBFKwMDQwkDAwMbw+AAvxgYGHpADvvDwMDAPEgcBQO/mAaho0CAjWkQOAIrGHUYqWDUYaSCUYeRCliIUf/1y3eGtasOMpw9fYPh44cvDP//o8pn5gYyWFhrw/m3bjxi+Pz5O4OxqTrtHPb58zeG6rJZDM+fvsGp5vv3nyj8yf1rGV48f8sQHefGEBBiRxuHLVmwE+woVTUZhrQsfwY5BXEGJib8KeDv379geumiXWCaHMcRdNjJY1fBdHFFJIOwCD/JFpDrOIKJ/+vXHwycXOxkOQrZcRvWHCJJD1GJn5GBEYX///9/hiuX7jF8//4Lq/qfP39jdRwDCSFHlMPQwcnj1xh6O5aTrI8Ux5FVjv1Ay4WkAGKjdUAKWJDjNq07jFfNgJX8yxbvwSs/YA6LinXBKz8gDgPVCH5BtnjVkOUwDk52ct1EdDVFVnFhbqnFUNeciLMcmzl1A8Onj1/JdhTRDvvPgNqcYGRkZNDVV8apfsGcrRQ5ioGYqOTm5mD4/u0nw9s3H4k2lFJHEeUwcytIOwtU0j+495zh379/NHcUAzFRGZPgznD92kOG27eeMJQWTMWqBtRQdHI1hvOZmZkpchQIgIYI/hNSNBAtWKIcNhBgtJdEKhh1GKlg1GGkApDD/g5Cd4GHOjuhA7KDBfxmYGDoAQC2Or9o/tkDuQAAAABJRU5ErkJggg=="/>
							</svg>
                        </span>
                        Sign Out
                     </a>
                  </li>
               </ul>
            </div>
         </div>
<?php $this->load->view('front/header/footer');  ?>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<script>
$(document).ready(function() 
{
	setTimeout(function(){ $('#msgBox').hide(); }, 3000);
});
function readImage(input,div_id) 
{
	document.getElementById('profile_pic').style.display="";
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$(div_id)
				.attr('src', e.target.result)
				.height(100);
		};

		reader.readAsDataURL(input.files[0]);
	}
	document.getElementById("myForm").submit();
}
</script>
<style>
.upload_btn_set
{
	position: fixed;
    right: 0px;
	padding-right: 120px;
	margin-top: -40px;
}
</style>