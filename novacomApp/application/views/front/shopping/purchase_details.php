<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('front/header/header'); 
	if($Ecommerce_flag==1) {						
            $cart_check = $this->cart->contents();
            if(!empty($cart_check)) {
                    $cart = $this->cart->contents(); 
                    $grand_total = 0; 
                    $item_count = COUNT($cart);  
            }
    }
    if($item_count <= 0 ) {
            $item_count=0;
    }
    else {
            $item_count = $item_count;
    }						
    if($Ecommerce_flag==1)
    {
            $wishlist = $this->wishlist->get_content();
            if(!empty($wishlist)) {

                    $wishlist = $this->wishlist->get_content();
                    $item_count2 = COUNT($wishlist); 

                    foreach ($wishlist as $item2) {

                            $Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
                    }
            } 
    }
    if($item_count2 <= 0 ) {
            $item_count2=0;
    }
    else {
            $item_count2 = $item_count2;
    }
?> 
<body style="background-image:url('<?php echo base_url(); ?>assets/img/order-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url();?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>My Order</h2>
				</div>
			</div>
		</div>
		<div class="custom-body transparent">
			<div class="order-body"> <?php
			if($Orders !=NULL)
			{
				foreach($Orders as $ords)
				{ 
					if($ords['Voucher_status']==20)//Delivered 
					{
						if($ords['Delivery_method']==28){
							$Voucher_status= 'Collected'; 
						} elseif($ords['Delivery_method']==29) {
							$Voucher_status= 'Delivered'; 
						} else{
							
							$Voucher_status=''; 
						}																	
					}
					elseif($ords['Voucher_status']==19)//Shipped
					{
						$Voucher_status=  'Shipped';
					}
					elseif($ords['Voucher_status']==21)//Cancel
					{
						$Voucher_status= 'Cancelled'; 
					}
					elseif($ords['Voucher_status']==22)//'Return Initiated'
					{
						$Voucher_status = 'return-initiated';
					}
					elseif($ords['Voucher_status']==18) //Ordered
					{
						$Voucher_status =  'Ordered'; 
					} 
					elseif($ords['Voucher_status']==23) //Returned
					{
						$Voucher_status = 'Returned';					
					} 
					else
					{
						$Voucher_status = "";
					}
					if($ords['Trans_type'] == 29)
					{
						$Bill_no = $ords['Order_no'];
					}
					else
					{
						$Bill_no = $ords['Bill_no'];
					}
				?>				
				<div class="card">
				  <div class="card-header">
				   <?php echo date("M d, Y, g:i A",strtotime($ords['Trans_date'])); ?>
				    <span class="float-right"><?php echo $Voucher_status; ?></span>
				  </div>
				  <div class="card-body d-flex justify-content-between">
				  	<div class="order-datail">
				    <p><strong>Order No:</strong> <?php echo $Bill_no; ?></p>
				    <p><strong>Total:</strong><?php echo "<b>".$Symbol_of_currency."</b>  ".$ords['Purchase_amount']; ?></p>
					</div>
					<div class="order-btn d-flex align-items-center">
						<a href="<?php echo base_url(); ?>index.php/Shopping/order_details/?serial_id=+<?php echo $ords['Bill_no']; ?>" class="btn btn-link">Details</a>
					</div>
				  </div>
				</div>
				<?php }
			}  ?>
			</div>
		</div>
<?php $this->load->view('front/header/footer');  ?>	