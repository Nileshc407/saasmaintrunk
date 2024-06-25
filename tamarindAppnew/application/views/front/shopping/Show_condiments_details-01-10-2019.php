<?php $i=1; ?>
<script>
$( document ).ready(function() 
{
    Show_next('<?php echo '#'.$i; ?>');
});
</script>
	
	<div class="modal-content">
		<div class="modal-body"  style="margin-top:0%;">
			<button type="button" class="close" aria-label="Close" data-dismiss="modal" id="close_modal">
			  &times;
			</button>
			<div class="modal-header">
			
			 <p id="Extra_large_font">Condiments And More For <b><?php echo $Merchandize_item_name; ?></b></p>
			</div>
			<section class="content-header" style="display:none;" id="error_display1" >
				<div class="row">	
					<div id="popup1">
						<div class="alert alert-success text-center" role="alert" id="popup_info1" style="background-color: #422d02 !important;" ></div>
					</div>
				</div>
			</section>
	<?php	
		
		if($Condiments_set1!=NULL)
		{ 
			$q2=$i+1;	
		?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<strong id="Medium_font"> &nbsp; &nbsp; Q<?php echo $i;?>.</strong>
				<strong id="Medium_font" style="text-align:left;width: 85%;"> Please select one of the below flavours for your <b><?php echo $Merchandize_item_name; ?></b>. (Required)</strong>
							<div class="col-md-2"> 
							</div> 
							<div class="col-md-6"> 
								<table id="myTable" align="left" class="text-left"> 
										<?php 
											
											foreach($Condiments_set1 as $set1)
											{ ?>
																								
												<tr>
													
													<td style="padding-top: .5em;padding-bottom: .5em;">
														
														<input type="radio" id="" name="Condiments_set1"  onclick="Show_next('<?php echo $q2; ?>');" value="<?php echo $set1['condiments_set1_code'].':'.$set1['condiments_set1_name']; ?>">
														
														 <label id="Value_font"> &nbsp;&nbsp;<?php echo $set1['condiments_set1_name']; ?> </label>
														 
														 
														 
													</td>																				
												</tr>															
													
									<?php	} $i=$i+1; ?>
								</table>
							</div>								
							<br>
			</div> <br/>
<?php 	}		
		if($Condiments_set2!=NULL)	
		{ 
	
			$q3=$i+1; ?> 
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?>  id="row_<?php echo $i; ?>">
			
				<strong id="Medium_font"> &nbsp; &nbsp; Q<?php echo $i;?>.</strong>
				<strong id="Medium_font" style="text-align:left;width: 85%;"> Please select the below dressing condiments. (Required)</strong>
				<div class="col-md-2"> 
							</div> 
							<div class="col-md-6"> 
								<table id="myTable" align="left" class="text-left"> 
									<?php 
										foreach($Condiments_set2 as $set2)
										{	?>
													
												<tr>
													<td style="padding-top: .5em;padding-bottom: .5em;">
														<input type="radio" name="Condiments_set2" onclick="Show_next('<?php echo $q3; ?>');" value="<?php echo $set2['condiments_set2_code'].':'.$set2['condiments_set2_name']; ?>">
														<span id="Value_font">&nbsp;&nbsp;<?php echo $set2['condiments_set2_name']; ?> </span>
													</td>																				
												</tr>
												
										
									<?php	}  $i=$i+1; ?>
								</table>
							</div>								
			</div>								
			<br>
				
		<?php 	
		}
		if($Condiments_set3!=NULL)	
		{ 
			$q4=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?>  id="row_<?php echo $i; ?>">
			
			<strong id="Medium_font"> &nbsp; &nbsp; Q<?php echo $i;?>.</strong>
				<strong id="Medium_font" style="text-align:left;width: 85%;"> The below condiment will spice up your <b><?php echo $Merchandize_item_name; ?>. (Required)</b> </strong>
				<div class="col-md-2"> 
							</div> 
							<div class="col-md-6"> 
								<table id="myTable" align="left" class="text-left">
					<?php
						
						foreach($Condiments_set3 as $set3)
						{	?>
							
								<tr>
													<td style="padding-top: .5em;padding-bottom: .5em;">
														<input type="radio" name="Condiments_set3" onclick="Show_next('<?php echo $q4; ?>');" value="<?php echo $set3['condiments_set3_code'].':'.$set3['condiments_set3_name']; ?>">
														<span id="Value_font">&nbsp;&nbsp;<?php echo $set3['condiments_set3_name']; ?>  </span>
													</td>																				
												</tr>
									
							
					<?php	}  $i=$i+1; ?>
				</table>
							</div>								
			</div>								
			<br>
<?php 
		}
		if($Condiments_set4!=NULL)	
		{ 
			$q5=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?>  id="row_<?php echo $i; ?>">
			
			<strong id="Medium_font"> &nbsp; &nbsp; Q<?php echo $i;?>.</strong>
				<strong id="Medium_font" style="text-align:left;width: 85%;">Please add drink options. (Required) </strong>
				<div class="col-md-2"> 
							</div> 
							<div class="col-md-6"> 
								<table id="myTable" align="left" class="text-left">
					<?php  
						foreach($Condiments_set4 as $set4)
						{	?>
						
												<tr>
													<td style="padding-top: .5em;padding-bottom: .5em;">
														<input type="radio" name="Condiments_set4" onclick="Show_next('<?php echo $q5; ?>');" value="<?php echo $set4['condiments_set4_code'].':'.$set4['condiments_set4_name']; ?>">
														<span id="Value_font">&nbsp;&nbsp;<?php echo $set4['condiments_set4_name']; ?></span>
													</td>																				
												</tr>
							
								
						
					<?php	}   $i=$i+1;?>
				</table>
							</div>								
			</div>								
			<br>
<?php 	}
		if($Condiments_set5!=NULL)	
		{
			$q6=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?>  id="row_<?php echo $i; ?>">
			
				<strong id="Medium_font"> &nbsp; &nbsp; Q<?php echo $i;?>.</strong>
				<strong id="Medium_font" style="text-align:left;width: 85%;"> Please add drink temprature. (Required)</strong>
				<div class="col-md-2"> 
							</div> 
							<div class="col-md-6"> 
								<table id="myTable" align="left" class="text-left">
					<?php  
						foreach($Condiments_set5 as $set5)
						{	?>
						
							<tr>
													<td style="padding-top: .5em;padding-bottom: .5em;">
														<input type="radio" name="Condiments_set5" onclick="Show_next('<?php echo $q6; ?>');" value="<?php echo $set5['condiments_set5_code'].':'.$set5['condiments_set5_name'];  ?>">
													<span id="Value_font">&nbsp;&nbsp;<?php echo $set5['condiments_set5_name']; ?> </span>
													</td>																				
												</tr>
								
							
						
					<?php	}  $i=$i+1; ?>
				</table>
							</div>								
			</div>								
			<br>
<?php 	}		
		if($Condiments_set6!=NULL)	
		{
			$q7=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?>  id="row_<?php echo $i; ?>">
			
			<strong id="Medium_font"> &nbsp; &nbsp; Q<?php echo $i;?>.</strong>
				<strong id="Medium_font" style="text-align:left;width: 85%;"> Please add drink options!</strong>
				<div class="col-md-2"> 
							</div> 
							<div class="col-md-6"> 
								<table id="myTable" align="left" class="text-left">
									<?php  
										foreach($Condiments_set6 as $set6)
										{	
										?>
										
											<tr>
												<td style="padding-top: .5em;padding-bottom: .5em;">
													<input type="checkbox" name="Condiments_set6" value="<?php echo $set6['condiments_set6_code']; ?>">
													<span id="Value_font">&nbsp;&nbsp; <?php echo $set6['condiments_set6_name']; ?> </span>
												</td>																				
											</tr>
									<?php	}  ?>
								</table>
							</div>								
			</div>								
			<br>
<?php 	} ?>
			<div class="modal-footer">
				<button type="button" id="button" class="b-items__item__add-to-cart" style="width: 85px;" onclick="add_to_cart_condiments('<?php echo $Merchandise_item_id; ?>', '<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $Merchandize_item_name); ?>', '<?php echo $price; ?>', '<?php echo $Delivery_method; ?>','<?php echo $Branch; ?>',<?php echo $Merchandise_item_id; ?>, '<?php echo $Item_size; ?>',<?php echo $Item_Weight; ?>,<?php echo $Weight_unit_id; ?>,<?php echo $Partner_id; ?>, '<?php echo $Partner_state; ?>', '<?php echo $Partner_Country_id; ?>',<?php echo $Seller_id; ?>,<?php echo $Merchant_flag; ?>, '<?php echo $Cost_price; ?>', '<?php echo $VAT; ?>', '<?php echo $Product_category_id; ?>','<?php echo $Item_code; ?>','<?php echo $Merchandize_item_name; ?>');">Click Ok</button>
				
				
				
				 
				 
			</div>
		</div>
	</div>

<?php /*
<script>
	var Title = "Application Information";
	var msg = "The item is currently unavailable";
	runjs(Title,msg);
</script> */ ?>
<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function()
	{
		// $('#item_info_modal').hide();
		$('#item_info_modal').modal('hide');
		
		// $("#item_info_modal").removeClass( "in" );
		// $('.modal-backdrop').remove();
	});
	
});

function add_to_cart_condiments(serial, name, price, Redemption_method, Branch, Company_merchandise_item_id, Item_size, Item_Weight, Weight_unit_id, Partner_id, Partner_state, Partner_Country_id, Seller_id, Merchant_flag, Cost_price, VAT, Product_category_id,Item_code,Item_name)
{	
	var Condiments_set1 = $("input[name='Condiments_set1']:checked").val();
	var Condiments_set2 = $("input[name='Condiments_set2']:checked").val();
	var Condiments_set3 = $("input[name='Condiments_set3']:checked").val();
	var Condiments_set4 = $("input[name='Condiments_set4']:checked").val();
	var Condiments_set5 = $("input[name='Condiments_set5']:checked").val();	
	
	
	var Condiments_set6_optional = [];
	$("input:checkbox[name=Condiments_set6]:checked").each(function()
	{
        Condiments_set6_optional.push($(this).attr("value"));
    });
	
	$.ajax(
		{
			type: "POST",
			data: {id: serial, name: name, price: price, Delivery_method: 29, Branch: Branch, Item_size: Item_size, Item_Weight: Item_Weight, Weight_unit_id: Weight_unit_id, Partner_id: Partner_id, Partner_state: Partner_state, Partner_Country_id: Partner_Country_id, Seller_id: Seller_id, Merchant_flag: Merchant_flag, Cost_price: Cost_price, VAT: VAT, Product_category_id: Product_category_id,Item_code:Item_code,Condiments_set1:Condiments_set1,Condiments_set2:Condiments_set2,Condiments_set3:Condiments_set3,Condiments_set4:Condiments_set4,Condiments_set5:Condiments_set5,Condiments_set6_optional:Condiments_set6_optional},
			url: "<?php echo base_url() ?>index.php/Shopping/add_to_cart_with_condiments",
			success: function (data)
			{
				if (data.cart_success_flag == 1)
				{
					 ShowPopup('Item <b>' + Item_name + '</b> is added to Cart.');
					 
					window.location.replace("<?php echo base_url()?>index.php/Shopping/view_cart");

				} 
			    else
				{
					ShowPopup('Error adding Product ' + name + ' to Cart. Please try again..!!');
				}
			}
		});
}
function ShowPopup(x)
{
	$('#popup_info1').html(x);
	$('#popup1').show();
	$('#error_display1').show();
	setTimeout('HidePopup()', 1000);
}
function HidePopup()
{
	$('#popup1').hide();
	$('#error_display1').hide();
}
function Show_next(flag)
{
	console.log(flag);	
	// $("[style]").removeAttr("style");
	// $(flag).css("display",""); 
	 $('#row_'+flag).removeAttr('style'); 
}
 </script>
 
 <style>
#popup 
{
	display:none;
}
div.square 
{
  border: solid 13px <?php echo $Product_details->Item_Colour; ?>;
  width: 0.5px;
  height: 0.5px;
  
  outline-color:gray;
  outline:1px solid;
}
.circle 
{
	color:white;
	height: 30px;
	margin: 9px;
	width: 30px;
     -webkit-border-radius: 25px;
     -moz-border-radius: 25px;
     border-radius: 25px;
     background: #45aed6;
	 float: left;
}
#b1
{
	margin-top:10px;
}
.modal-footer 
{
    text-align: left ! IMPORTANT;
}
 </style>
 