									
									
									
									
									<div class="widget" id="records">
									<?php 
									
									foreach($result as $rec) {
										
												if($rec['Code_decode']=='Ordered')
												{
														$order_class= 'progtrckr-done';
														$shipped_class= 'progtrckr-todo';
														$delivered_class= 'progtrckr-todo';
														
														
												}
												if($rec['Code_decode']=='Shipped')
												{
														$order_class= 'progtrckr-done';
														$shipped_class= 'progtrckr-done';
														$delivered_class= 'progtrckr-todo';
												}
												if($rec['Code_decode']=='Delivered')
												{
														$order_class= 'progtrckr-done';
														$shipped_class= 'progtrckr-done';
														$delivered_class= 'progtrckr-done';
												}
												else
												{
													$order_class= 'progtrckr-done';
													$other_class= 'progtrckr-cancel';
												}
												
												
										?>
									   <div class="widget-body text-xs-center text-sm-left" >
											<div class="row">
												<div class="col-sm-2">
													<img src="<?php echo $rec['Item_image1']; ?>" width="100" height="100" id="Item_image" alt="Order ">
												</div>
													
												<div class="col-sm-10">
													<h5>Reference No. #<span id="Ordernumber3"><?php echo $rec['Voucher_no']; ?></span></h5> 
													<b>Order Date :</b> <span id="Orderdate"><?php echo $rec['Trans_date']; ?></span><br>
													<b>Order Status :</b> <span id="Orderstatus"><?php echo $rec['Code_decode']; ?></span></p>
													<?php if($rec['Code_decode']=='Ordered' || $rec['Code_decode']=='Shipped' || $rec['Code_decode']=='Delivered' )
													{
												?>
													<ol class="progtrckr" data-progtrckr-steps="3" >
													<li id="order_class" class='<?php echo $order_class; ?>'>Ordered</li><!--
													 --><li  id="shipped_class" class='<?php echo $shipped_class; ?>'>Shipped</li><!--
													 --><li  id="delivered_class" class='<?php echo $delivered_class; ?>'>Delivered</li>
													</ol>
													 <?php }else{ ?>	
														<ol class="progtrckr" data-progtrckr-steps="2" >
													<li id="order_class" class='<?php echo $order_class; ?>'>Ordered</li><!--
													 --><li  id="other_class" class='<?php echo $other_class; ?>'><?php echo $rec['Code_decode']; ?></li>
													</ol>
													 <?php } ?>								
			</div>
											</div>
									   </div><br>
									   <?php } ?>
									</div>
									
									
									

<style>

ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3.5em;
}

ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-cancel {
    color: black;
    border-bottom: 4px solid red;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}

ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-cancel:before {
    content: "\2713";
    color: white;
    background-color: red;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 2.2em;
    bottom: -1.2em;
}









</style>									