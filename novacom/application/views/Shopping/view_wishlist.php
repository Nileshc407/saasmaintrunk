<?php
$this->load->view('header/header');
$wishlist = $this->wishlist->get_content();
$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
?>

<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<!-- ----------------------Product Quick Look------------------------ -->
    <link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/styleQ.css">
    <script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/modernizr.js"></script> 
<!-- ----------------------Product Quick Look------------------------ -->

<section class="content-header">
    <h1>My Wishlist</h1>	 
</section>

<!-- Main content -->
<section class="content">

    <div class="row">	
        <div class="col-md-6 col-md-offset-3" id="popup">
            <div class="alert alert-success text-center" role="alert" id="popup_info"></div>
        </div>
    </div>

    

        <?php if( empty($wishlist) ) { ?>
            <div class="col-md-12">
                <p class="text-muted lead text-center">Your Wishlist is Empty. Please click on Add to Wishlist to Add items to Wishlist.</p>
                <p class="text-center">
                    <a href="<?php echo base_url()?>index.php/Shopping" class="btn btn-template-main">
                        <i class="fa fa-chevron-left"></i>&nbsp;Continue shopping
                    </a>
                </p>
            </div>
        <?php } ?>

        <?php
        if( $wishlist = $this->wishlist->get_content() )
        {
            $item_count = COUNT($wishlist);
        ?>

        <div class="row products cd-container" id="FilterResult">
        <!-- <div class="col-md-12 clearfix">

            <div class="row products"> -->

                <?php 
					
							
                foreach ($wishlist as $item) 
                {									
                    $Product_details = $ci_object->Shopping_model->get_products_details($item['id']);
                ?>

                    <?php /* <div class="col-md-3 col-sm-4">

                            <div class="product">

                                    <div class="image">
                                            <a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>">
                                                    <img src="<?php echo $Product_details->Thumbnail_image1; ?>" alt="<?php echo $Product_details->Merchandize_item_name; ?>" class="img-responsive image1" style="margin: 0px auto;">
                                            </a>
                                    </div>

                                    <div class="text">
                                            <h3>
                                                    <a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>">
                                                            <?php echo $Product_details->Merchandize_item_name; ?>
                                                    </a>
                                            </h3>
                                            <p class="price">
                                                    <b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format((float)$Product_details->Billing_price, 2); ?>
                                            </p>
                                            <p class="text-center">
                                                    <button type="button" class="btn btn-template-main" onclick="move_to_cart('<?php echo $Product_details->Company_merchandise_item_id;; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>','<?php echo $item['rowid']; ?>');">
                                                            <i class="fa fa-shopping-cart"></i>&nbsp;Move to cart
                                                    </button>

                                                    <a href="<?php echo base_url()?>index.php/Shopping/remove_wishlist/?rowid=<?php echo $item['rowid']; ?>" title="Remove" class="btn btn-default" data-toggle="tooltip" data-placement="top">
                                                            <i class="fa fa-trash-o"></i>&nbsp;
                                                    </a>										
                                            </p>
                                    </div>

                            </div>

                    </div> */ ?>

                    <div class="col-md-3">

                        <div class="product">
                            <div class="small-box bg-aqua" style="z-index: 0;">
                                <a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>" class="cd-trigger small-box-footer">
                                    <i class="fa fa-eye"></i> Quick Details
                                </a>
                            </div>

                            <div class="image" id="Source_img_<?php echo $Product_details->Company_merchandise_item_id; ?>">
                                <a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>">
                                    <img src="<?php echo $Product_details->Thumbnail_image1; ?>" alt=""  style="height:200px;" alt="Item Preview">
                                </a>
                            </div>

                            <div class="text">
                                <h5 style="min-height: 35px;"><a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>"><?php echo $Product_details->Merchandize_item_name; ?></a></h5>
                                <p class="price">Price - <b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $Product_details->Billing_price; ?></p>
								<?php
									$Get_Partner_details = $ci_object->Igain_model->Get_Company_Partners_details($Product_details->Partner_id);
									$Partner_state=$Get_Partner_details->State;
									$Partner_Country=$Get_Partner_details->Country_id;
									
									if($Product_details->Size_flag == 1) 
									{ 
										$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$Product_details->Company_merchandize_item_code);	
										$Billing_price = $Get_item_price->Billing_price;
										$Item_size=$Get_item_price->Item_size;	
									} 
									else 
									{
										$Item_size="0";
										$Billing_price = $Product_details->Billing_price;		
									}
									/* $Branches = $Redemption_Items_branches[$Product_details->Company_merchandize_item_code];
									 
									foreach ($Branches as $Branches2){
										$DBranch_code=$Branches2['Branch_code'];
										$DBranch_id=$Branches2['Branch_id'];
									}*/
									
									$Branch_code = $ci_object->Igain_model->get_partner_branch($Company_id,$Product_details->Company_merchandize_item_code);	
									$DBranch_code=$Branch_code->Branch_code;
										// echo "DBranch_code-------------".$DBranch_code;
								?>
							<input type="hidden" name="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">	
							
                                <div class="text">
                                    <p class="text-center">
                                       <?php /* <button type="button" class="btn btn-template-main" onclick="move_to_cart('<?php echo $Product_details->Company_merchandise_item_id;; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>','<?php echo $item['rowid']; ?>');">
                                            <i class="fa fa-shopping-cart"></i>&nbsp;Move to cart
                                        </button>*/ ?>
										
										<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $Product_details->Company_merchandise_item_id; ?>,'<?php echo $Item_size; ?>',<?php echo $Product_details->Item_Weight; ?>,<?php echo $Product_details->Weight_unit_id; ?>,<?php echo $Product_details->Partner_id; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $Product_details->Seller_id; ?>,<?php echo $Product_details->Merchant_flag; ?>,'<?php echo $Product_details->Cost_price; ?>','<?php echo $Product_details->VAT; ?>','<?php echo $Product_details->Merchandize_category_id; ?>'); move_to_cart('<?php echo $item['rowid']; ?>');" style="width: 70%;padding: 6px 2px;">
										<i class="fa fa-shopping-cart"></i> Move to cart
										</button>

                                        <a href="<?php echo base_url()?>index.php/Shopping/remove_wishlist/?rowid=<?php echo $item['rowid']; ?>" title="Remove" class="btn btn-default" data-toggle="tooltip" data-placement="top">
                                        <i class="fa fa-trash-o"></i>&nbsp;
                                        </a>
                                    </p>
                                </div>
                             </div>
                        </div>
                    </div>
                <?php } ?>
            <!-- </div>
        </div> -->
        <?php } ?>
    </div>
</section>
		
<?php $this->load->view('header/footer'); ?>	  

<style>
#popup 
{
	display:none;
}
</style>

<script type="text/javascript" charset="utf-8">
function move_to_cart(rowid)
{
	$.ajax({
		type: "POST",
		data: {rowid:rowid },
		url: "<?php echo base_url()?>index.php/Shopping/move_to_cart",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+name+' is Moved to Cart..!!');				
				$('.shoppingCart_total').html('$'+data.cart_total);
				location.reload(true);
			}
			else
			{
				ShowPopup('Error Moving Product '+name+' to Cart. Please try again..!!');
				$('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}
function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id)
{
	// alert('Item_size'+Item_size);
	// alert('Branch'+Branch);
	 show_loader();
	/*var Checked_Delivery_method = $("input[name=Delivery_method_"+Company_merchandise_item_id+"]:checked").val();
		 if(Checked_Delivery_method==29)
		{
			Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		} 
		*/
		Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		// alert(Branch);
	$.ajax( 
        {
            type: "POST",
            data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id},
            url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
            success: function(data)
            {
                    if(data.cart_success_flag == 1)
                    {
						ShowPopup('Product '+name+' is Moved to Cart..!!');				
						$('.shoppingCart_total').html('$'+data.cart_total);
						location.reload(true);
                    }
                    else
                    {
						ShowPopup('Error Moving Product '+name+' to Cart. Please try again..!!');
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

/*****************************Quick View Pop-up*********************************/
function Set_trigger_id(Company_merchandise_item_id)
{
    $('#TriggerItem').val(Company_merchandise_item_id);
}

$('.cd-trigger').on('click', function(event)
{
    var Company_merchandise_item_id = $('#TriggerItem').val();    
    $.ajax(
    {
        type: "POST",
        data: { Company_merchandise_item_id:Company_merchandise_item_id },
        url: "<?php echo base_url()?>index.php/Shopping/Get_itemDetails",
        success: function(data)
        {
            $('#Quick_image').html('<li class="selected"><img src="'+data.Item_image1+'"></li>');   /*<li><img src="'+data.Item_image2+'"></li><li><img src="'+data.Item_image3+'"></li><li><img src="'+data.Item_image4+'"></li>*/
            $('#Quick_name').html(data.Merchandize_item_name);
            $('#Quick_desc').html(data.Merchandise_item_description);
            
            $("#Popup_addcart").attr("onclick","add_to_cart("+Company_merchandise_item_id+",'"+data.Merchandize_item_name+"','"+data.Billing_price+"');");
            $("#Popup_wishlist").attr("onclick","add_to_wishlist("+Company_merchandise_item_id+",'"+data.Merchandize_item_name+"','"+data.Billing_price+"');");
            
            var image = $('#Source_img_'+Company_merchandise_item_id).find('img');   
            var finalWidth = 500;   var maxQuickWidth = 750;            
            animateQuickView(image, finalWidth, maxQuickWidth, 'open');
        }
    });
});

$('.cd-close').on('click', function(event)
{
    var finalWidth = 500;   var maxQuickWidth = 750;
    var Company_merchandise_item_id = $('#TriggerItem').val();
    var close = $('.cd-close'),
            activeSliderUrl = close.siblings('.cd-slider-wrapper').find('.selected img').attr('src'),
            selectedImage = $('#Source_img_'+Company_merchandise_item_id).find('img');
        
    if( !$('.cd-quick-view').hasClass('velocity-animating') && $('.cd-quick-view').hasClass('add-content')) 
    {
        selectedImage.attr('src', activeSliderUrl);
        animateQuickView(selectedImage, finalWidth, maxQuickWidth, 'close');
    } 
    else 
    {
        closeNoAnimation(selectedImage, finalWidth, maxQuickWidth);
    }
});

function closeNoAnimation(image, finalWidth, maxQuickWidth) 
{ 
    var parentListItem = image.parent('.cd-item'),
        topSelected = image.offset().top - $(window).scrollTop(),
        leftSelected = image.offset().left,
        widthSelected = image.width();

    $('body').removeClass('overlay-layer');
    parentListItem.removeClass('empty-box');
    $('.cd-quick-view').velocity("stop").removeClass('add-content animate-width is-visible').css(
    {
        "top": topSelected,
        "left": leftSelected,
        "width": widthSelected,
    });
}

function animateQuickView(image, finalWidth, maxQuickWidth, animationType) 
{
    var parentListItem = image.parent('.cd-item'),
        topSelected = image.offset().top - $(window).scrollTop(),
        leftSelected = image.offset().left,
        widthSelected = '120',//image.width(),
        heightSelected = image.height(),
        windowWidth = $(window).width(),
        windowHeight = $(window).height(),
        finalLeft = (windowWidth - finalWidth)/2,
        finalHeight = finalWidth * heightSelected/widthSelected,
        finalTop = (windowHeight - finalHeight)/2,
        quickViewWidth = ( windowWidth * .8 < maxQuickWidth ) ? windowWidth * .8 : maxQuickWidth ,
        quickViewLeft = (windowWidth - quickViewWidth)/2;

    if( animationType == 'open') 
    {
        parentListItem.addClass('empty-box');
        $('.cd-quick-view').css(
        {
            "top": topSelected,
            "left": leftSelected,
            "width": widthSelected,
        }).velocity(
        {
            'top': finalTop+ 'px',
            'left': finalLeft+'px',
            'width': finalWidth+'px',
        }, 1000, [ 400, 20 ], function()
        {
            $('.cd-quick-view').addClass('animate-width').velocity(
            {
                'left': quickViewLeft+'px',
                'width': quickViewWidth+'px',
            }, 300, 'ease' ,function()
            {
                $('.cd-quick-view').addClass('add-content');
            });
        }).addClass('is-visible');
    } 
    else 
    {
        $('.cd-quick-view').removeClass('add-content').velocity(
        {
            'top': finalTop+ 'px',
            'left': finalLeft+'px',
            'width': finalWidth+'px',
        }, 300, 'ease', function()
        {
            $('body').removeClass('overlay-layer');
            $('.cd-quick-view').removeClass('animate-width').velocity(
            {
                "top": topSelected,
                "left": leftSelected,
                "width": widthSelected,
            }, 500, 'ease', function()
            {
                $('.cd-quick-view').removeClass('is-visible');
                parentListItem.removeClass('empty-box');
            });
        });
    }
}
/*****************************Quick View Pop-up*********************************/
</script>