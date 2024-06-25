<?php
$this->load->view('header/header');
  $session_data = $this->session->userdata('cust_logged_in');
  $smartphone_flag = $session_data['smartphone_flag'];
  
  $wishlist = $this->wishlist->get_content();  
  $Wishlist_item = array();
  if (!empty($wishlist)) {
    foreach ($wishlist as $item) {
      $Wishlist_item[$item['id']] = $item['id'];
    }
  }
  $ci_object = &get_instance();
  $ci_object->load->model('Redemption_Model');
  $ci_object->load->model('Igain_model');
  $ci_object->load->model('shopping/Shopping_model');

?>
   
<link href="<?php echo $this->config->item('base_url2') ?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2') ?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2') ?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, user-scalable=no" />

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.skinNice.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/bootstrap-slider/slider.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/iCheck/all.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/select2/select2.min.css">	

<script>
$( document ).ready(function() 
{
	var Current_address = '<?php echo $Enroll_details->Current_address; ?>';
   if(Current_address =="" || Current_address == NULL)
   {	
		BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'Please update your primary address in profile.',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/profile';
				}
			}]
		});
   }
});
</script>

<?php
if (@$this->session->flashdata('Redeem_flash')) {
?>
	<script>
	  var Title = "Application Information";
	  var msg = '<?php echo $this->session->flashdata('Redeem_flash'); ?>';
	  runjs(Title, msg);
	</script>
<?php
}
if ($Enroll_details->Card_id == '0' || $Enroll_details->Card_id == "") {
?>
<script>
  BootstrapDialog.show({
	  closable: false,
	  title: 'Application Information',
	  message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
	  buttons: [{
			  label: 'OK',
			  action: function (dialog) {
				  window.location = '<?php echo base_url() ?>index.php/Cust_home/home';
			  }
		  }]
  });
  runjs(Title, msg);
</script>
<?php } ?>

<section class="content-header">
	<div class="row">
		<div class="col-xs-12 col-md-4">
			<img src="<?php echo base_url();?>Website_Images/Image1.1.png" width="100%" height="100%" align="center">
		</div>
		<div class="col-xs-12 col-md-4">
			<img src="<?php echo base_url();?>Website_Images/Image2.2.png" width="100%" height="100%" align="center">
		</div>
		<div class="col-xs-12 col-md-4">
			<img src="<?php echo base_url();?>Website_Images/Image3.3.png" width="100%" height="100%" align="center">
		</div>		
	</div>	
</section>	

<section class="content-header">
    <div class="row">	
        <div class="col-md-2 col-xs-2">
            <h3>Menu</h3>
        </div>
		<div class="col-md-8 col-xs-8">
           <p style="color: #5e4103;"><b><br/>All orders made on this site are only for PICKUP at our Kimathi branch but check us out on Glovo, Glovo Courier or  UberEats for  home deliveries.</b></p>
        </div>
        <div class="col-md-2 col-xs-2"> 
            <button type="button" class="btn btn-info btn-lg" data-toggle="control-sidebar" data-placement="top" title="Filter" style="margin-top:10px;background: #5e4103 none repeat scroll 0 0;border-color: #5e4103; float: right;">
                <i class="fa fa-filter" aria-hidden="true"></i>
            </button>				
        </div>
    </div>
</section>	
			
<div class="row">&nbsp;</div>   
<!-- Main content -->
<section class="content">
    <div class="row">	
        <div class="col-md-6 col-md-offset-3" id="popup">
            <div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color:#5e4103 !IMPORTANT"></div>
        </div>
    </div>
    <div id="content">		
		<div class="row products cd-container" id="FilterResult">
			<div class="col-md-3" id="Food_Categories">
			<div class="form-group has-feedback">
				<input type="text" name="Search_item" id="Search_item" class="form-control" placeholder="Search by item name" onchange="Sort_by_name(this.value);">	
			</div>
				<div class="list-group">
				  <a href="#" class="list-group-item list-group-item-action active">
					Categories
				  </a>
				  <a href="#" onclick="Sort_by_category('');" class="list-group-item list-group-item-action" <?php if($_REQUEST["Sort_by_category_flag"]=="") { ?> style=" background-color:#ec979726; font-weight: bold;" <?php } ?>>All</a>
				<?php
					foreach($Merchandize_category as $MerchandizeCat)
					{ ?>
						<a href="#" onclick="Sort_by_category(<?php echo $MerchandizeCat->Merchandize_category_id; ?>);" class="list-group-item list-group-item-action" <?php if($MerchandizeCat->Merchandize_category_id==$_REQUEST["Sort_by_category_flag"]) { ?> style=" background-color:#ec979726; font-weight: bold;" <?php } ?> > <?php echo $MerchandizeCat->Merchandize_category_name; ?> </a>
			<?php	}	?>
				</div>
			</div>
			<div class="col">
			<?php
				if ($Redemption_Items != NULL) 
				{
					foreach ($Redemption_Items as $product) 
					{
						$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];
						
				//******** sandeep **********************
						$allergies = $ci_object->Shopping_model->Get_Selected_item_condiments_details($product['Company_merchandize_item_code'],$Company_id,18);

						
				//******** sandeep **********************
				
						  /* $ci_object = &get_instance();
						  $ci_object->load->model('shopping/Shopping_model');
						  $Count_item_offer = $ci_object->Shopping_model->get_count_item_offers($product["Company_merchandise_item_id"], $product['Company_id']); */

						  $Company_merchandise_item_id = $product['Company_merchandise_item_id'];													
						  $Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
						  $Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
						?>
						<div class="col-md-2" style="margin-right:20px;">
							<div class="product" id="product1" style="height:250px;">									
								<div class="small-box bg-aqua" style="z-index: 0;  background-color: #332005 ! important;margin-bottom: 2px;">
								  <a href="<?php echo base_url() ?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>" class="cd-trigger small-box-footer">
									  <i class="fa fa-eye"></i>View Details
								  </a>
								</div>
								<?php
								$Get_Partner_details = $ci_object->Igain_model->Get_Company_Partners_details($product["Partner_id"]);
								$Partner_state = $Get_Partner_details->State;
								$Partner_Country = $Get_Partner_details->Country_id;
								
								  if ($product['Size_flag'] == 1) {
									$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id, $product['Company_merchandize_item_code']);
									$Billing_price = $Get_item_price->Billing_price;
									$Item_size = $Get_item_price->Item_size;
								  } else {
									$Item_size = "0";
									$Billing_price = $product['Billing_price'];
								  }
								  
								  foreach ($Branches as $Branches2) {
									$DBranch_code = $Branches2['Branch_code'];
									$DBranch_id = $Branches2['Branch_id'];
								  }

									$Company_merchandise_item_id = $product['Company_merchandise_item_id'];													
									$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
									$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
								?>
									
								<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">
								
								<div class="text" style="padding: 4px;"> 
									<h5 style="line-height: 1em; height: 2em; overflow: hidden;">
										<a href="<?php echo base_url() ?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
											<?php  $M_item_name = (explode("+",$product['Merchandize_item_name'])); 
											
											if($product['Combo_meal_flag'] == 1)
											{
												$M_item_name = $M_item_name['0'];
											}
											else
											{
												$M_item_name = $product['Merchandize_item_name'];
											} 	?>
											
										  <?php echo $M_item_name;  ?>
										</a>
									</h5><br>
								  <?php 
									if($product['Combo_meal_flag'] == 1) { ?>
									<p style="line-height: 1em; height: 3em; overflow: hidden;">
										<?php $des_length = strlen($product['Merchandise_item_description']);
										if($des_length > 35) { echo substr($product['Merchandise_item_description'], 0, 50)." ..."; } else { echo $product['Merchandise_item_description']; } ?>
									</p>
								<?php	} ?>
									<p class="price" style="line-height: 1em; height: 2em; overflow: hidden;"><b>
										<?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $Billing_price; ?>
									</p>
							 
									<div class="text">
										<p class="text-center">
											<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>', '<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $product["Merchandize_item_name"]); ?>', '<?php echo $Billing_price; ?>', 29, 29,<?php echo $product['Company_merchandise_item_id']; ?>, '<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>, '<?php echo $Partner_state; ?>', '<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>, '<?php echo $product['Cost_price']; ?>', '<?php echo $product['VAT']; ?>', '<?php echo $product['Merchandize_category_id']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $M_item_name; ?>');" style="width: 100%;padding: 6px 2px; font-size: 10px;">
											  <i class="fa fa-shopping-cart"></i> Add to cart
											</button>
										</p>
									</div>
									<div class="text">
									<?php
							
										foreach($allergies as $alrg)
										{
											$alrg_item_name = $ci_object->Igain_model->Get_codedecode_row($alrg->Condiment_item_code);

											echo "<span class=\"label label-success\">".$alrg_item_name->Code_decode."</span>";
										}
									?>
									</div>
								</div>
							</div>
						</div>											
					  <?php

					}
				}  ?>
			</div>
        </div>
        <div class="panel-footer">
		<?php
		  if ($numitems > $count4) {
			$nextpage = 2;
		  }
		?>       
        </div>
        <div class="box-footer" style="padding:0px;margin-top:0px;background: #fff;border-top:none">
            <div class="row" style="margin-right:0px; margin-left:0px;">
                <div class="col-md-6 col-xs-6">
				<?php echo $pagination; ?>
                </div>
                <div class="col-md-6 col-xs-6" align="right">
                    <button type="button" class="btn btn-default pagination" name="submit"   id="submit2"  onclick="javascript:window.location = '<?php echo base_url() ?>index.php/Shopping/view_cart';" style="margin-left: auto;margin-right: auto;">Checkout&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
                    <input type="hidden" id="SelectedCat" />
                    <input type="hidden" id="SelectedSort" />
                    <input type="hidden" id="TriggerItem" />
                    <input type="hidden" id="track_page" value="1" />
                    <input type="hidden" id="numitems" value="<?php //echo $nextpage;  ?>" />
                </div>
            </div>					
        </div> <br>
			
		<div class="row" style="background-color:#332005;"> 
			<div class="col-md-6 col-xs-12" style="text-align: right;">
				<img src="<?php echo base_url();?>Website_Images/Phone.png" width="10%" height="10%" align="center">
				&nbsp;<span style="color: white; font-size: 20px;">Download our app : </span>
			</div>
			<div class="col-md-6 col-xs-12">
				<br>
				<?php if($Company_Details->Cust_apk_link != NULL) { ?>
				<div class="col-md-6 col-xs-6">
					<a href="<?php echo $Company_Details->Cust_apk_link; ?>">
						<img src="<?php echo base_url();?>Website_Images/google-play.png" style="width:180px;">
					</a>
				</div>
				<?php } if($Company_Details->Cust_ios_link != NULL) { ?>
				<div class="col-md-6 col-xs-6">
					<a href="<?php echo $Company_Details->Cust_ios_link; ?>">
						<img src="<?php echo base_url();?>Website_Images/iosstore.png" style="width:170px;">
					</a>  
				</div>
				<?php } ?>
			</div>
		</div>	 	
    </div>
<!-- Modal -->
<div id="item_info_modal" class="modal fade" role="dialog" style="overflow:auto;">
	<div class="modal-dialog" style="width: 70%;" id="Show_item_info">
		<div class="modal-content" >
			<div class="modal-header">
				<div class="modal-body">
					<div class="table-responsive" id="Show_item_info"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->	
</section>
<!------------------------New Filter---------------------------->
<style>
ul 
{
	list-style-type: none;
}
.sidebar-menu2>li>a
{
	padding:12px 5px 12px 0px;display:block;

	border-left-color: #3c8dbc;
}
sidebar-menu2>li>a:hover
{
	background:#f4f4f5;
}
ol, ul 
{
	margin-top: 0;
	margin-bottom: 10px;
	margin-left: -21px;
}
</style>
<!-----------------Right side filter-------------------->
<aside class="control-sidebar control-sidebar-dark">
    <section class="sidebar">
        <div class="pad">
            <div class="panel panel-default sidebar-menu" style="background: transparent none repeat scroll 0% 0%; border: medium none;">
                <div class="panel-body">
                    <ul class="sidebar-menu2">
                        <li>
                            <a href="#" data-toggle="control-sidebar" class="text-right filter_header" style="color: #fff;"><i class="fa fa-remove"></i></a>
                        </li>     <?php /*              
                        <li class="treeview" style="line-height:0px;">
                            <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;">Price</a>
                            <ul>
                                <li>
                                    <input id="range_1" type="text" name="range_1">
                                </li>
                                <li>&nbsp;</li>
                            </ul>
                        </li> */ ?>          
                        <li class="treeview" onclick="hide_sort_by();" style="line-height:0px;">
                            <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-usd"></span> Sort By Price</a>
                            <div id="sortby_point" style="display:none">
                                <ul>
                                    <li>
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" value="1" class="flat-red Sort_radio" id="Sort_radio_1" name="Sort_by" <?php if ($Sort_by == 1) {
              echo "checked=checked";
            } ?> onclick="Sort_by_points(this.value);">&nbsp;&nbsp;
                                                Price: Low to High
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" value="2" class="flat-red Sort_radio" id="Sort_radio_2" name="Sort_by" <?php if ($Sort_by == 2) {
              echo "checked=checked";
            } ?> onclick="Sort_by_points(this.value);">&nbsp;&nbsp;
                                                Price: High to Low
                                            </label>
                                        </div>
                                    </li>                         
                                    <li>
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" value="3" class="flat-red Sort_radio" id="Sort_radio_3" name="Sort_by" <?php if ($Sort_by == 3) {
              echo "checked=checked";
            } ?> onclick="Sort_by_points(this.value);">&nbsp;&nbsp;
                                                Recently Added
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> 
                        <?php /*<li class="treeview" onclick="hide_merchant();" style="line-height:0px;">
                            <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-user"></span> Outlet</a>
                            <div id="sortby_merchant" style="display:none">
<?php if ($Sellers != NULL) { ?>

                                    <ul <?php if (count($Sellers) > 4) {
      echo 'style="height: 180px; overflow: auto;"';
    } ?> >

                                        <li>
                                            <div class="form-group">
                                                <label style="text-transform: capitalize;">
                                                    <input type="radio" name="Sort_merchants" id="Sort_merchants" class="flat-red" value="0" <?php if ($Merchant_filter == 0) {
      echo "checked=checked";
    } ?> onclick="Sort_by_merchants(this.value);">&nbsp;&nbsp;
                                                    All
                                                </label>
                                            </div>
                                        </li>

                                    <?php foreach ($Sellers as $Sellers) { ?>							
                                          <li>
                                              <div class="form-group">
                                                  <label style="text-transform: capitalize;"> 
                                                      <input type="radio" name="Sort_merchants" id="Sort_merchants<?php echo $Sellers['Enrollement_id']; ?>" class="flat-red" value="<?php echo $Sellers['Enrollement_id']; ?>" <?php if ($Merchant_filter == $Sellers['Enrollement_id']) {
                                  echo "checked=checked";
                                } ?> onclick="Sort_by_merchants(this.value);">&nbsp;&nbsp;
      <?php echo $Sellers['First_name'] . ' ' . $Sellers['Last_name']; ?>
                                                  </label>
                                              </div>
                                          </li>
    <?php } ?>
                                    </ul>
                                      <?php } ?>
                            </div>
                        </li> */ ?>
                        <li onclick="hide_catagory();" style="line-height:0px;">
                            <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-th-list"></span> Categories</a>
                            <div id="sortby_category" style="display:none">  
<?php if ($Merchandize_category != NULL) { ?>

                                    <ul <?php if (count($Merchandize_category) > 4) {
      echo 'style="height: 400px; overflow: auto;"';
    } ?> >

                                        <li>
                                            <div class="form-group">
                                                <label>
                                                    <input type="radio" name="Sort_cat" id="Sort_cat_0" class="flat-red" value="0" <?php if ($Category_filter == 0) {
      echo "checked=checked";
    } ?> onclick="Sort_by_category(this.value);">&nbsp;&nbsp;
                                                    All
                                                </label>
                                            </div>
                                        </li>

    <?php foreach ($Merchandize_category as $MerchandizeCat) { ?>
                                          <li>
                                              <div class="form-group">
                                                  <label>
                                                      <input type="radio" name="Sort_cat" id="Sort_cat_<?php echo $MerchandizeCat->Merchandize_category_id; ?>" class="flat-red" value="<?php echo $MerchandizeCat->Merchandize_category_id; ?>" <?php if ($Category_filter == $MerchandizeCat->Merchandize_category_id) {
        echo "checked=checked";
      } ?> onclick="Sort_by_category(this.value);">&nbsp;&nbsp;
                                          <?php echo $MerchandizeCat->Merchandize_category_name; ?>
                                                  </label>
                                              </div>
                                          </li>
                                                    <?php } ?>
                                    </ul>

  <?php } ?>
                            </div>
                        </li>
        <?php /*        <li class="treeview" onclick="hide_sort_brand();" style="line-height:0px;">
                            <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-heart"></span> Brand</a>
                            <div id="sortby_brand" style="display:none">
<?php if ($Item_brand != NULL) { ?>
                                    <ul <?php if (count($Item_brand) > 4) {
      echo 'style="height: 180px; overflow: auto;"';
    } ?>>
                                        <li>
                                            <div class="form-group">
                                                <label style="text-transform: capitalize;">
                                                    <input type="radio" name="Sort_brand" id="Sort_brand" class="flat-red" value="0" <?php if ($brand_filter == 0) {
      echo "checked=checked";
    } ?> onclick="Sort_by_brand(this.value);">&nbsp;&nbsp;
                                                    All
                                                </label>
                                            </div>
                                        </li>
                                        <?php foreach ($Item_brand as $brand) { ?>
                                          <li>
                                              <div class="form-group">
                                                  <label style="text-transform: capitalize;">
                                                      <input type="radio" name="Sort_brand" id="Sort_brand<?php echo $brand->Item_Brand; ?>" class="flat-red" value="<?php echo $brand->Item_Brand; ?>" <?php if ($brand_filter == $brand->Item_Brand) {
                                            echo "checked=checked";
                                          } ?> onclick="Sort_by_brand(this.value);">&nbsp;&nbsp;
      <?php echo $brand->Item_Brand; ?>
                                                  </label>
                                              </div>
                                          </li>
                                        <?php }
                                      }
                                    ?>
                                </ul>
                            </div>
                        </li> 
                        <li class="treeview" onclick="hide_sort_gender();" style="line-height:0px;">
                            <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-user"></span> Gender</a>
                            <div id="sortby_gender" style="display:none">

                                <ul <?php if (count($Gender_flag) > 4) {
                                        echo 'style="height: 180px; overflow: auto;"';
                                      } ?>>


                                    <li>
                                        <div class="form-group">
                                            <label style="text-transform: capitalize;">
                                                <input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="0" <?php if ($_REQUEST["Sort_by_gender_flag"] == 0) {
                                        echo "checked=checked";
                                      } ?> onclick="Sort_by_gender(this.value);">&nbsp;&nbsp;Both	
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label style="text-transform: capitalize;">
                                                <input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="1" <?php if ($_REQUEST["Sort_by_gender_flag"] == 1) {
                                        echo "checked=checked";
                                      } ?> onclick="Sort_by_gender(this.value);">&nbsp;&nbsp;Men	
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label style="text-transform: capitalize;">
                                                <input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="2" <?php if ($_REQUEST["Sort_by_gender_flag"] == 2) {
                                        echo "checked=checked";
                                      } ?> onclick="Sort_by_gender(this.value);">&nbsp;&nbsp;Women										
                                            </label>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> */ ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</aside>
<!-----------------Right side filter-------------------->
<div class="control-sidebar-bg"></div>
<?php $this->load->view('header/loader'); 
 $this->load->view('header/footer'); ?>

<div id="loadingDiv" style="display:none;">
    <div>
        <h7>Please wait...</h7>
    </div>
</div>

<script src="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<script src="<?php echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<!--<script src="<?php //echo $this->config->item('base_url2') ?>assets/Customer_assets/plugins/iCheck/icheck.min.js"></script>-->

<style>
#popup 
{
	display:none;
}
#popup2 
{
	display:none;
}
.filter_header:hover{background-color: #222D32 !important;background: #222D32 !important;}

.Qimage
{
	min-height: 250px;
}

.Qaction {
	border-bottom: 1px solid #31859c;
	border-top: 1px solid #31859c;
	height: 35px;
	padding: 6px;
}

.Qaction > p {
	float: left;
	text-align: center;
	width: 45%;
}

.Qaction > p.devider {
	float: left;
	text-align: center;
	width: 10%;
}

.btn-template-main.disabled, .btn-template-main[disabled], fieldset[disabled] .btn-template-main, .btn-template-main.disabled:hover, .btn-template-main[disabled]:hover, fieldset[disabled] .btn-template-main:hover, .btn-template-main.disabled:focus, .btn-template-main[disabled]:focus, fieldset[disabled] .btn-template-main:focus, .btn-template-main.disabled:active, .btn-template-main[disabled]:active, fieldset[disabled] .btn-template-main:active, .btn-template-main.disabled.active, .btn-template-main.active[disabled], fieldset[disabled] .btn-template-main.active {background-color: #38a7bb !important;}

#popup 
{
	display:none;
}
#popup2 
{
	display:none;
}
#loadingDiv{
	position:fixed;
	top:0px;
	right:0px;
	width:100%;
	height:100%;
	background-color:#666;
	background-image:url('<?php echo $this->config->item('base_url2') ?>images/loading.gif');
	background-repeat:no-repeat;
	background-position:center;
	z-index:10000000;
	opacity: 0.4;
	filter: alpha(opacity=40); /* For IE8 and earlier */ 
}
ul 
{
	list-style-type: none;
}
</style>

<script type="text/javascript" charset="utf-8">
$(document).ready(function ()
{
  var numitems = '<?php echo $numitems; ?>';
  var count4 = '<?php echo $count4; ?>';

  if (numitems > count4)
  {
	  $('#LoadMoreDiv').show();
	  //var nextpage = 2;
	  //$('#numitems').val(nextpage);
  }
});

$(function ()
{
  $('.slider').slider();

  $("#range_1").ionRangeSlider(
		  {
			  min: '<?php echo round($Min_price->Billing_price); ?>',
			  max: '<?php echo round($Max_price->Billing_price); ?>',
			  from: '<?php echo round($Min_price->Billing_price); ?>',
			  to: '<?php echo round($Min_price->Billing_price); ?>',
			  type: 'double',
			  //step: 20,
			  prefix: "",
			  prettify: false,
			  hasGrid: false,
			  onFinish: function (data)
			  {
				  var from = data.fromNumber;
				  var to = data.toNumber;
				  var SelectedSort = $('#SelectedSort').val();
				  var SelectedCat = $('#SelectedCat').val();
				  filter_result(SelectedSort, SelectedCat, from, to);
			  }
		  });

  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck(
		  {
			  checkboxClass: 'icheckbox_flat-green',
			  radioClass: 'iradio_flat-green'
		  });
});
function filter_result(Sort_by, Sort_category, PriceFrom, PriceTo)
{
  //var track_page = $('#track_page').val();
  var track_page = '1'; //$('#numitems').val();
  var Company_id = '<?php echo $Company_id; ?>';
  $.ajax(
			{
			  type: "POST",
			  data: {page: track_page, Sort_by: Sort_by, Company_id: Company_id, Sort_category: Sort_category, PriceFrom: PriceFrom, PriceTo: PriceTo},
			  url: "<?php echo base_url() ?>index.php/Shopping/filter_result",
			  success: function (data)
			  {
				  //$("#FilterResult").replaceWith(data.filtered_result);
				  $("#FilterResult").html(data.filtered_result);
			  }
			});
}

function add_to_cart(serial, name, price, Redemption_method, Branch, Company_merchandise_item_id, Item_size, Item_Weight, Weight_unit_id, Partner_id, Partner_state, Partner_Country_id, Seller_id, Merchant_flag, Cost_price, VAT, Product_category_id,Item_code,Item_name)
{
  Branch = document.getElementById("Delivery_" + Company_merchandise_item_id).value;

  $.ajax(
		{
			type: "POST",
			data: {id: serial, name: name, price: price, Delivery_method: 29, Branch: Branch, Item_size: Item_size, Item_Weight: Item_Weight, Weight_unit_id: Weight_unit_id, Partner_id: Partner_id, Partner_state: Partner_state, Partner_Country_id: Partner_Country_id, Seller_id: Seller_id, Merchant_flag: Merchant_flag, Cost_price: Cost_price, VAT: VAT, Product_category_id: Product_category_id,Item_code:Item_code,Item_name:Item_name},
			url: "<?php echo base_url() ?>index.php/Shopping/add_to_cart",
			success: function (data)
			{
					if (data.cart_success_flag == 1)
					{
						ShowPopup('Product ' + Item_name + ' is added to Cart Successfuly..!!');
						$('.shoppingCart_total').html('$' + data.cart_total);
						//   location.reload(true);
						setTimeout('location.reload(true)', 500);
					} 
					else
					{
						// ShowPopup('Error adding Product ' + name + ' to Cart. Please try again..!!');
						// $('.shoppingCart_total').html('$' + data.cart_total);
						// location.reload(true);
						// setTimeout('location.reload(true)', 5000);
						
						$("#Show_item_info").html(data.transactionReceiptHtml);	
						$('#item_info_modal').show();
						$("#item_info_modal").addClass( "in" );	
					}
			}
		});
}

function add_to_wishlist(serial, name, price)
{
  $.ajax(
		  {
			  type: "POST",
			  data: {id: serial, name: name, price: price},
			  url: "<?php echo base_url() ?>index.php/Shopping/add_to_wishlist",
			  success: function (data)
			  {
				  if (data.cart_success_flag == 1)
				  {
					  ShowPopup('Product ' + name + ' is added to Wishlist..!!');
					  $('.shoppingCart_total').html('$' + data.cart_total);
					  location.reload(true);
				  } else
				  {
					  ShowPopup('Error adding Product ' + name + ' to Wishlist. Please try again..!!');
					  $('.shoppingCart_total').html('$' + data.cart_total);
					  location.reload(true);
					  
				  }
			  }
		  });
}

function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup_info').css('position','fixed');
	$('#popup_info').css('z-index','1');
	$('#popup_info').css('right','0');
	$('#popup_info').css('top','auto');
	$('#popup_info').css('bottom','50%');
	$('#popup').show();
	setTimeout('HidePopup()', 5000);
}

function HidePopup()
{
  $('#popup').hide();
}

/*****************************Load MOre Items*********************************/
</script>
<script type="text/javascript" charset="utf-8">
<?php
  if ($Redemption_Items == NULL) { ?>
      ShowPopup('Items Not Found !!!');
 <?php } ?>

  function Sort_by_category(Merchandize_category)
  {
      document.getElementById("loadingDiv").style.display = "";
      var filter = 0;
      var merchant = 0;
      var brand = 0;
      var gender = 0;
      var item_name = '';
<?php
  if (isset($_REQUEST["Sort_by_points_flag"])) {
 ?>
        var filter = '<?php echo $_REQUEST["Sort_by_points_flag"]; ?>';
<?php } 
  if (isset($_REQUEST["Sort_by_merchant_flag"])) {
    ?>
        var merchant = '<?php echo $_REQUEST["Sort_by_merchant_flag"]; ?>';
<?php } 
  if (isset($_REQUEST["Sort_by_brand_flag"])) {
    ?>
        var brand = '<?php echo $_REQUEST["Sort_by_brand_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_gender_flag"])) {
 ?>
        var gender = '<?php echo $_REQUEST["Sort_by_gender_flag"]; ?>';
<?php } ?>

      window.location = '<?php echo base_url() ?>index.php/Shopping/?Sort_by_points_flag=' + filter + '&Sort_by_category_flag=' + Merchandize_category + '&Sort_by_merchant_flag=' + merchant + '&Sort_by_brand_flag=' + brand + '&Sort_by_gender_flag=' + gender+ '&Sort_by_item_name=' + item_name;
  } 
  function Sort_by_name(item_name)
  {
      document.getElementById("loadingDiv").style.display = "";
	  var Merchandize_category = 0;
      var filter = 0;
      var merchant = 0;
      var brand = 0;
      var gender = 0;
<?php
  if (isset($_REQUEST["Sort_by_category_flag"])) {
 ?>
         var Merchandize_category = '<?php echo $_REQUEST["Sort_by_category_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_points_flag"])) {
 ?>
          var filter = '<?php echo $_REQUEST["Sort_by_points_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_merchant_flag"])) {
    ?>
          var merchant = '<?php echo $_REQUEST["Sort_by_merchant_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_brand_flag"])) {
 ?>
          var brand = '<?php echo $_REQUEST["Sort_by_brand_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_gender_flag"])) {
 ?>
          var gender = '<?php echo $_REQUEST["Sort_by_gender_flag"]; ?>';
<?php } ?>

      window.location = '<?php echo base_url() ?>index.php/Shopping/?Sort_by_points_flag=' + filter + '&Sort_by_category_flag=' + Merchandize_category + '&Sort_by_merchant_flag=' + merchant + '&Sort_by_brand_flag=' + brand + '&Sort_by_gender_flag=' + gender+ '&Sort_by_item_name=' + item_name;
  }

  function Sort_by_points(filter)
  {
      document.getElementById("loadingDiv").style.display = "";
      var Merchandize_category = 0;
      var merchant = 0;
      var brand = 0;
      var gender = 0;
      var item_name = '';

<?php
  if (isset($_REQUEST["Sort_by_category_flag"])) {
 ?>
        var Merchandize_category = '<?php echo $_REQUEST["Sort_by_category_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_merchant_flag"])) {
  ?>
       var merchant = '<?php echo $_REQUEST["Sort_by_merchant_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_brand_flag"])) {
 ?>
       var brand = '<?php echo $_REQUEST["Sort_by_brand_flag"]; ?>';
<?php } 
  if (isset($_REQUEST["Sort_by_gender_flag"])) {
 ?>
       var gender = '<?php echo $_REQUEST["Sort_by_gender_flag"]; ?>';
<?php } ?>

      window.location = '<?php echo base_url() ?>index.php/Shopping/?Sort_by_points_flag=' + filter + '&Sort_by_category_flag=' + Merchandize_category + '&Sort_by_merchant_flag=' + merchant + '&Sort_by_brand_flag=' + brand + '&Sort_by_gender_flag=' + gender + '&Sort_by_item_name=' + item_name;
  }
  function Sort_by_merchants(merchant)
  {
      document.getElementById("loadingDiv").style.display = "";
      var Merchandize_category = 0;
      var filter = 0;
      var brand = 0;
      var gender = 0;
      var item_name = '';
<?php
  if (isset($_REQUEST["Sort_by_category_flag"])) {
    ?>
        var Merchandize_category = '<?php echo $_REQUEST["Sort_by_category_flag"]; ?>';
 <?php }
  if (isset($_REQUEST["Sort_by_points_flag"])) {
    ?>
        var filter = '<?php echo $_REQUEST["Sort_by_points_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_brand_flag"])) {
?>
        var brand = '<?php echo $_REQUEST["Sort_by_brand_flag"]; ?>';
<?php } 
if (isset($_REQUEST["Sort_by_gender_flag"])) {
 ?>
       var gender = '<?php echo $_REQUEST["Sort_by_gender_flag"]; ?>';
<?php } ?>
      window.location = '<?php echo base_url() ?>index.php/Shopping/?Sort_by_points_flag=' + filter + '&Sort_by_category_flag=' + Merchandize_category + '&Sort_by_merchant_flag=' + merchant + '&Sort_by_brand_flag=' + brand + '&Sort_by_gender_flag=' + gender + '&Sort_by_item_name=' + item_name;
  }
  function Sort_by_brand(brand)
  {
      document.getElementById("loadingDiv").style.display = "";
      var Merchandize_category = 0;
      var filter = 0;
      var merchant = 0;
      var gender = 0;
      var item_name = '';
<?php
  if (isset($_REQUEST["Sort_by_category_flag"])) {
 ?>
        var Merchandize_category = '<?php echo $_REQUEST["Sort_by_category_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_points_flag"])) {
 ?>
       var filter = '<?php echo $_REQUEST["Sort_by_points_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_merchant_flag"])) {
 ?>
       var merchant = '<?php echo $_REQUEST["Sort_by_merchant_flag"]; ?>';
<?php }
if (isset($_REQUEST["Sort_by_gender_flag"])) {
 ?>
      var gender = '<?php echo $_REQUEST["Sort_by_gender_flag"]; ?>';
<?php } ?>
      window.location = '<?php echo base_url() ?>index.php/Shopping/?Sort_by_points_flag=' + filter + '&Sort_by_category_flag=' + Merchandize_category + '&Sort_by_merchant_flag=' + merchant + '&Sort_by_brand_flag=' + brand + '&Sort_by_gender_flag=' + gender + '&Sort_by_item_name=' + item_name;
  }
  function Sort_by_gender(gender)
  {
      document.getElementById("loadingDiv").style.display = "";
      var Merchandize_category = 0;
      var filter = 0;
      var merchant = 0;
      var brand = 0;
      var item_name = '';
<?php
  if (isset($_REQUEST["Sort_by_category_flag"])) {
 ?>
          var Merchandize_category = '<?php echo $_REQUEST["Sort_by_category_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_points_flag"])) {
 ?>
          var filter = '<?php echo $_REQUEST["Sort_by_points_flag"]; ?>';
<?php }
 if (isset($_REQUEST["Sort_by_merchant_flag"])) {
 ?>
          var merchant = '<?php echo $_REQUEST["Sort_by_merchant_flag"]; ?>';
<?php }
  if (isset($_REQUEST["Sort_by_brand_flag"])) {
 ?>
          var brand = '<?php echo $_REQUEST["Sort_by_brand_flag"]; ?>';
<?php } ?>

      window.location = '<?php echo base_url() ?>index.php/Shopping/?Sort_by_points_flag=' + filter + '&Sort_by_category_flag=' + Merchandize_category + '&Sort_by_merchant_flag=' + merchant + '&Sort_by_brand_flag=' + brand + '&Sort_by_gender_flag=' + gender + '&Sort_by_item_name=' + item_name;
  }
  function HidePopup()
  {
      $('#popup').hide();
      //$('#popup2').hide();
      //$('#popup3').hide();
  }
<!---------------------------------- New filter-------------------------------->
  function hide_sort_by()
  {
      //$("#sortby_point").show();
      var x = document.getElementById('sortby_point');
      if (x.style.display === 'none')
      {
          x.style.display = 'block';
      } 
      else
      {
          x.style.display = 'none';
      }
  }
  function hide_catagory()
  {
      //$("#sortby_category").show();
      var x = document.getElementById('sortby_category');
      if (x.style.display === 'none')
      {
          x.style.display = 'block';
      } 
	  else
      {
          x.style.display = 'none';
      }
  }
  function hide_merchant()
  {
      //$("#sortby_merchant").show();
      var x = document.getElementById('sortby_merchant');
      if (x.style.display === 'none')
      {
          x.style.display = 'block';
      } 
	  else
      {
          x.style.display = 'none';
      }
  }
  function hide_sort_brand()
  {
      //$("#sortby_category").show();
      var x = document.getElementById('sortby_brand');
      if (x.style.display === 'none')
      {
          x.style.display = 'block';
      } 
	  else
      {
          x.style.display = 'none';
      }
  }
  function hide_sort_gender()
  {
      //$("#sortby_category").show();
      var x = document.getElementById('sortby_gender');
      if (x.style.display === 'none')
      {
          x.style.display = 'block';
      }
	  else
      {
          x.style.display = 'none';
      }
  }
</script>
<script>
  function Show_branch(Company_merchandise_item_id, flag)
  {
      if (flag == 1)
      {
          document.getElementById(Company_merchandise_item_id).style.display = "";
      }
	  else
      {
          document.getElementById(Company_merchandise_item_id).style.display = "none";
      }
  }
</script>
<style>
/* .content-wrapper{
	min-height:1% !IMPORTANT;
} */

/* .col-md-3
{
	margin-left:5%;
} 
*/

.popover__title {
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 17px;
	/* line-height: 36px; */
	text-decoration: none;
	color: rgb(228, 68, 68);
	text-align: center;
	position: absolute;
	z-index: 1;
	left: 72px;
	top: -20px;
}

.popover__wrapper {
	position: relative;
	margin-top: -8px;
  /*   display: inline-block; */
}
.popover__content {
	opacity: 0;
	visibility: hidden;
	position: absolute;
	left: 21px;
	transform: translate(0,10px);
	background-color: #00add7;
	color: #fff;
	padding: 1.5rem;
	box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	width: 200px;
}
.popover__content:before {
	position: absolute;
	z-index: -1;
	content: '';
	right: calc(50% - 10px);
	top: -8px;
	border-style: solid;
	border-width: 0 10px 10px 10px;
	border-color: transparent transparent #BFBFBF transparent;
	transition-duration: 0.3s;
	transition-property: transform;
}
.popover__wrapper:hover .popover__content {
	z-index: 10;
	opacity: 1;
	visibility: visible;
	transform: translate(0,-20px);
	transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}
.popover__message {
	text-align: center;
}
        
#upper_left {
    width: 125px; height: 125px;
    position: absolute;
    top: -53px;
    left: 144px;
    background-image: url("<?php echo $this->config->item('base_url2') ?>images/special-offers1.png");
    background-repeat: no-repeat;
   z-index: 1;
}
/*.list-group-item.active
{
	background-color: #00add7 !IMPORTANT;
	border-color: #00add7 !IMPORTANT;
} */
#Food_Categories
{
	/* height:1000px ; */
	min-height: 635px;
}

@media screen and (min-width: 320px) 
{
	#product1 {
		width: 105%;
	}
}
@media screen and (min-width: 768px) 
{
	#product1 {
		width: 120%;
	}
}
</style>	