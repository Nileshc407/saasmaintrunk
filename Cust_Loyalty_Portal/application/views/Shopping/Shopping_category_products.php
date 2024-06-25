<?php
$this->load->view('header/header');
$wishlist = $this->wishlist->get_content();
$ci_object = &get_instance();

$Wishlist_item = array();
if( !empty($wishlist) )
{
	foreach ($wishlist as $item) 
	{
		$Wishlist_item[$item['id']] = $item['id'];
	}
}
?>
	
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.skinNice.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/bootstrap-slider/slider.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/all.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/select2/select2.min.css">

<section class="content-header">	
	
	<div class="row">
		<div class="col-md-12">
			
			<nav class="navbar navbar-default navbar-static-top" style="background-color: #3c8dbc;">
			
				<div class="container-fluid">
				
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						
						<?php foreach($Product_groups as $groups) { ?>
							<li>
								<a href="<?php echo base_url()?>index.php/Shopping/Shopping_category_products/?Product_group=<?php echo $groups['Product_group_id']; ?>" class="text-center"><?php echo $groups['Product_group_name']; ?></a>
							</li>
						<?php } ?>
						
						</ul>
					</div>
					
				</div>
				
			</nav>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-left">Category - <?php echo $Product_group_details->Product_group_name; ?></h3>
		</div>
	</div>
	
</section>
		
<!-- Main content -->
<section class="content">

	<div class="row" style="padding: 10px;border-bottom: 1px solid #367fa9;padding-bottom: 10px;">
		<div class="col-md-6" style="">
			<a href="#" class="dropdown-toggle" data-toggle="control-sidebar">
				<i class="fa fa-bars"></i>
				Filter
			</a>
		</div>
		
		<div class="col-md-6 text-right">
			<div class="btn-group">
				<button type="button" class="btn btn-template-main dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Sort By
					<i class="fa fa-sort"></i>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li>
						<a href="javascript:void(0);" onclick="filter_result('<?php echo $Product_group_details->Product_group_id; ?>','','',range_1.value,'1')">
							Newest Arrivals
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" onclick="filter_result('<?php echo $Product_group_details->Product_group_id; ?>','','',range_1.value,'2')">
							Price: Low to High
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" onclick="filter_result('<?php echo $Product_group_details->Product_group_id; ?>','','',range_1.value,'3')">
							Price: High to Low
						</a>
					</li>
				</ul>
			</div>
			
		</div>
	</div><br>

	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup">
			<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
		</div>
	</div>

	<div id="content">
		
		<div class="row products" id="FilterResult">
	
			<?php
			if($Shopping_category_products != NULL)
			{
				foreach ($Shopping_category_products as $product)
				{
			?>
			
					<div class="col-md-3 col-sm-4">
						<div class="product">
							<div class="image">
								<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>">
									<img src="<?php echo $product['Thumbnail_image1']; ?>" alt="" class="img-responsive image1">
								</a>
							</div>
							
							<div class="text">
								<h3>
									<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>">
										<?php echo $product['Merchandize_item_name']; ?>
									</a>
								</h3>
								<p class="price">Price - <b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $product['Billing_price']; ?></p>
								<p class="text-center">
									<button type="submit" class="btn btn-template-main" onclick="add_to_cart('<?php echo $product['Company_merchandise_item_id']; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product['Merchandize_item_name']); ?>','<?php echo $product['Billing_price']; ?>');">
										<i class="fa fa-shopping-cart"></i> Add to cart
									</button>
									
									<?php
									$Style = "";										
									if (array_key_exists($product['Company_merchandise_item_id'], $Wishlist_item))
									{
										if( $Wishlist_item[$product['Company_merchandise_item_id']] == $product['Company_merchandise_item_id'])
										{
											$Style = "style='background: #38a7bb none repeat scroll 0 0;border-color: #38a7bb;color: #ffffff;'";
									?>	
									
											<button type="button" <?php echo $Style; ?> class="btn btn-template-main" data-toggle="tooltip" data-placement="top" title="Already Added to wishlist">
												<i class="fa fa-heart-o"></i>&nbsp;
											</button>

									<?php
										}
									}
									else
									{
									?>
									
										<button type="button" <?php echo $Style; ?> class="btn btn-template-main" onclick="add_to_wishlist('<?php echo $product['Company_merchandise_item_id']; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product['Merchandize_item_name']); ?>','<?php echo $product['Billing_price']; ?>');" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
											<i class="fa fa-heart-o"></i>&nbsp;
										</button>
									
									<?php
									}
									?>								
									
								</p>
							</div>
						</div>
					</div>
					
			<?php
				}
			}
			?>
				
		</div>
			
	</div>
	
</section>


<aside class="control-sidebar control-sidebar-dark">

	<div class="pad">
		
		<div class="panel panel-default sidebar-menu" style="background: transparent none repeat scroll 0% 0%; border: medium none;">

			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked category-menu">
				
					<li>
						<a href="#" data-toggle="control-sidebar" class="text-right filter_header"><i class="fa fa-remove"></i></a>
					</li>
					
					<li>
						<a href="#" class="filter_header">Price</a>
						<ul>
							<li>&nbsp;</li>
							<li>
								<input id="range_1" type="text" name="range_1">
							</li>
							<li>&nbsp;</li>
							<li>&nbsp;</li>
						</ul>
					</li>
					
					<li>
						<a href="#" class="filter_header">Brand</a>
						
						<?php if($Product_brands != NULL) { ?>
						
						<ul <?php if( count($Product_brands) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } ?> >						
							<?php foreach($Product_brands as $brands) { ?>
								<li>
									 <div class="form-group">
										<label>	<!-- class="flat-red"  -->
											<input type="checkbox" id="Brand_<?php echo $brands['Product_brand_name']; ?>" onclick="filter_result('<?php echo $Product_group_details->Product_group_id; ?>','<?php echo $brands['Product_brand_id']; ?>','Brand_<?php echo str_replace(' ', '_', $brands['Product_brand_name']); ?>',range_1.value,'');">&nbsp;&nbsp;
											<?php echo $brands['Product_brand_name']; ?>
										</label>
									</div>
								</li>
							<?php } ?>
						</ul>
						
						<?php } ?>
					</li>
					
					<li>&nbsp;</li>

					<?php /* <li>
						<a href="#" class="filter_header">Color</a>
						
						<?php if($Product_colors != NULL) { ?>
						
						<ul <?php if( count($Product_colors) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } ?> >
							<?php foreach($Product_colors as $colors) { ?>
								<li>
									 <div class="form-group">
										<label>
											<input type="checkbox" id="Color_<?php echo $colors['Color']; ?>" onclick="filter_result('<?php echo $Product_group_details->Product_group_id; ?>','','<?php echo $colors['Color']; ?>','','Color_<?php echo $colors['Color']; ?>',range_1.value,'')">&nbsp;&nbsp;
											<?php echo $colors['Color']; ?>
										</label>
									</div>
								</li>
							<?php } ?>
						</ul>
						
						<?php } ?>
					</li> */ ?>
				</ul>

			</div>
		</div>
	</div>

</aside>
<div class="control-sidebar-bg"></div>


<?php $this->load->view('header/loader');?>
<?php $this->load->view('header/footer');?>

<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/icheck.min.js"></script>
<script>
var filter_brand = [];
var filter_color = [];
var Sort = [];

$(function () 
{
	alert('<?php echo $Cart_redeem_point; ?>');
	$('.slider').slider();

	$("#range_1").ionRangeSlider(
	{
		min: 0,
		max: <?php echo round($Max_price->Billing_price); ?>,
		from: 0,
		to: <?php echo round($Max_price->Billing_price); ?>,
		type: 'double',
		step: 50,
		prefix: "",
		prettify: false,
		hasGrid: false,
		
		onFinish: function (data)
		{
			var from = data.fromNumber;
			var to = data.toNumber;				
			var Price = from + ";" + to;			
			var Product_group_id = '<?php echo $Product_group_details->Product_group_id; ?>';
			var BrandDiv = '';	var ColorDiv = '';
			// filter_result(Product_group_id,filter_brand,filter_color,BrandDiv,ColorDiv,Price)
			
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				type: "POST",
				data: { Product_group_id:Product_group_id, Company_id:Company_id, filter_brand:filter_brand, PriceFrom:from, PriceTo:to, Sort:Sort },
				url: "<?php echo base_url()?>index.php/Shopping/filter_result",
				success: function(data)
				{
					$("#FilterResult").replaceWith(data.filtered_result);
				}
			});
		}
	});
	
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
});


function filter_result(Product_group_id,Product_brand_id,Brand_div,price,Sorting)
{
	// filter_color.push(Color);
	filter_brand.push(Product_brand_id);
	
	price = price.split(";");
	var PriceFrom = price[0];
	var PriceTo = price[1];
	
	if($("#"+Brand_div).prop('checked') == false)
	{
		filter_brand = jQuery.grep(filter_brand, function(value)
						{
							return value != Product_brand_id;
						});
	}
	
	/* if($("#"+Color_div).prop('checked') == false)
	{
		filter_color = jQuery.grep(filter_color, function(value)
					{
						return value != Color;
					});
	} */
	
	filter_brand = jQuery.unique( filter_brand );
	filter_color = jQuery.unique( filter_color );
	
	filter_brand = filter_brand.filter(Boolean);
	filter_color = filter_color.filter(Boolean);
	
	Sort.unshift(Sorting);
	Sort = jQuery.unique( Sort );
	
	var Company_id = '<?php echo $Company_id; ?>';
	$.ajax({
		type: "POST",
		data: { Product_group_id:Product_group_id, Company_id:Company_id, filter_brand:filter_brand, PriceFrom:PriceFrom, PriceTo:PriceTo, Sort:Sort },
		url: "<?php echo base_url()?>index.php/Shopping/filter_result",
		success: function(data)
		{
			$("#FilterResult").replaceWith(data.filtered_result);
		}
	});
}
	
function add_to_cart(serial,name,price)
{
	$.ajax({
		type: "POST",
		data: { id:serial, name:name, price:price },
		url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
				$('.shoppingCart_total').html('$'+data.cart_total);
				location.reload(true);
			}
			else
			{
				ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
				$('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}

function add_to_wishlist(serial,name,price)
{
	$.ajax({
		type: "POST",
		data: { id:serial, name:name, price:price },
		url: "<?php echo base_url()?>index.php/Shopping/add_to_wishlist",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+name+' is added to Wishlist..!!');				
				$('.shoppingCart_total').html('$'+data.cart_total);
				location.reload(true);
			}
			else
			{
				ShowPopup('Error adding Product '+name+' to Wishlist. Please try again..!!');
				$('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}

function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	setTimeout('HidePopup()', 1000);
}

function HidePopup()
{
	$('#popup').hide();
}
</script>

<style>
#popup 
{
	display:none;
}

.carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      /* width: 100%; */
      margin: 0 auto;
  }
  
.carousel-content {
    color:black;
    display:flex;
    align-items:center;
	color: #fff;
	margin: 0 auto;
}

.image1
{
    margin: 0 auto;
}

.image 
{
	min-height: 225px;
    margin: 15px; auto;
}

.filter_header:hover{background-color: #222D32 !important;background: #222D32 !important;}

/* .nav > li > a:focus, .nav > li > a:hover{background-color: #222D32 !important;background: #222D32 !important;} */
.nav > li > a:focus, .nav > li > a:hover{background: rgba(0, 0, 0, 0.1) none repeat scroll 0 0 !important;}

.nav > li > a {
	color: #fff !important;
}
</style>