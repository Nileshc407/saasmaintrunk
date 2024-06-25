<?php
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

if($Filter_result != NULL)
{
    foreach ($Filter_result as $product)
    {
?>

        <li class="cd-item col-md-3" style="padding-left: 0;padding-right: 0;border-radius: 5px;">
            <div class="Qimage" align="center" id="Source_img_<?php echo $product["Company_merchandise_item_id"]; ?>">
                <img src="<?php echo $product['Thumbnail_image1']; ?>" class="img-responsive" alt="Item Preview">
                <a href="javascript:void(0);" class="cd-trigger" onclick="Set_trigger_id(<?php echo $product["Company_merchandise_item_id"]; ?>);">Quick View</a>
            </div>

            <div class="Qaction">
                <p>
                    <a href="javascript:void(0);" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $product["Billing_price"]; ?>');" data-toggle="tooltip" data-placement="top" title="Add to Cart">
                        <i class="fa fa-shopping-cart"></i> Add to cart
                    </a>
                </p>

                <p class="devider">|</p>

                <p>
                    <?php
                    $Style = "";										
                    if (array_key_exists($product['Company_merchandise_item_id'], $Wishlist_item))
                    {
                        if( $Wishlist_item[$product['Company_merchandise_item_id']] == $product['Company_merchandise_item_id'])
                        {
                            $Style = "style='background: #38a7bb none repeat scroll 0 0;border-color: #38a7bb;color: #ffffff;'";
                    ?>	

                            <a href="javascript:void(0);" <?php echo $Style; ?> data-toggle="tooltip" data-placement="top" title="Already Added to wishlist">
                                <i class="fa fa-heart-o"></i>&nbsp;Added to Wishlist
                            </a>

                    <?php
                        }
                    }
                    else
                    {
                    ?>

                        <a href="javascript:void(0);" <?php echo $Style; ?> onclick="add_to_wishlist('<?php echo $product['Company_merchandise_item_id']; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product['Merchandize_item_name']); ?>','<?php echo $product['Billing_price']; ?>');" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
                            <i class="fa fa-heart-o"></i>&nbsp;Wishlist
                        </a>

                    <?php
                    }
                    ?>
                </p>
            </div>

            <h5 class="text-center" style="font-weight: bold;">
                <a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>" style="color: black;"><?php echo $product['Merchandize_item_name']; ?></a>
            </h5>
            <p class="price text-center">Price - <b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $product['Billing_price']; ?></p>
        </li>
        
<?php
    }
}
?>

<script>
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
            $('body').attr('class','skin-blue sidebar-mini overlay-layer');
            $('#Quick_image').html('<li class="selected"><img src="'+data.Item_image1+'"></li>');   /*<li><img src="'+data.Item_image2+'"></li><li><img src="'+data.Item_image3+'"></li><li><img src="'+data.Item_image4+'"></li>*/
            $('#Quick_name').html(data.Merchandize_item_name);
            $('#Quick_desc').html(data.Merchandise_item_description);
            
            $("#Popup_addcart").attr("onclick","add_to_cart("+Company_merchandise_item_id+",'"+data.Merchandize_item_name+"','"+data.Billing_price+"');");
            $("#Popup_wishlist").attr("onclick","add_to_wishlist("+Company_merchandise_item_id+",'"+data.Merchandize_item_name+"','"+data.Billing_price+"');");
            
            var image = $('#Source_img_'+Company_merchandise_item_id).find('img');            
            var finalWidth = 400;   var maxQuickWidth = 750;            
            animateQuickView(image, finalWidth, maxQuickWidth, 'open');
        }
    });
});
</script>