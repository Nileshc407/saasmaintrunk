<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>css_slider/etalage.css">
<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.etalage.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php $i=1; ?>
<script>
$( document ).ready(function() 
{
    Show_next('<?php echo '#'.$i; ?>');
});
</script>	

	<div class="modal-content" id="item_info_modal">
		<div class="modal-body" style="margin-top:0%;">
			<div class="modal-header">
			<button type="button" class="close" aria-label="Close" id="close_modal">
			<i class="fa fa-window-close" aria-hidden="true"></i> 
			</button>
			  <h4 class="modal-title">Condiments And More For <b><?php echo $Merchandize_item_name; ?></b></h4>
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
		{ $q2=$i+1;	?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q<?php echo $i;?>. Please select one of the below flavours for your <b><?php echo $Merchandize_item_name; ?></b>. (Required)</h5>
				<?php 
					foreach($Condiments_set1 as $set1)
					{ ?>
					<div class="col-md-3"> 
						<input type="radio" name="Condiments_set1"  onclick="Show_next('<?php echo '#'.$q2; ?>');" value="<?php echo $set1['condiments_set1_code'].':'.$set1['condiments_set1_name']; ?>">&nbsp;&nbsp;<?php echo $set1['condiments_set1_name']; ?> 
					</div>
			<?php	} $i=$i+1; ?>
			</div> <br/>
<?php 	} 
		if($Condiments_set2!=NULL)	
		{ $q3=$i+1; ?> 
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q<?php echo $i;?>. Please select the below dressing condiments. (Required)</h5>
				<?php 
					foreach($Condiments_set2 as $set2)
					{	?>
					<div class="col-md-3"> 
						<input type="radio" name="Condiments_set2" onclick="Show_next('<?php echo '#'.$q3; ?>');" value="<?php echo $set2['condiments_set2_code'].':'.$set2['condiments_set2_name']; ?>">&nbsp;&nbsp;<?php echo $set2['condiments_set2_name']; ?> 
					</div>
			<?php	}  $i=$i+1; ?>
			</div><br/>
<?php 	
		} 
		if($Condiments_set3!=NULL)	
		{ $q4=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q<?php echo $i;?>. The below condiment will spice up your <b><?php echo $Merchandize_item_name; ?>. (Required)</b></h5>
				<?php
					
					foreach($Condiments_set3 as $set3)
					{	?>
					<div class="col-md-3"> 
						<input type="radio" name="Condiments_set3" onclick="Show_next('<?php echo '#'.$q4; ?>');" value="<?php echo $set3['condiments_set3_code'].':'.$set3['condiments_set3_name']; ?>">&nbsp;&nbsp;<?php echo $set3['condiments_set3_name']; ?> 
					</div>
			<?php	}  $i=$i+1; ?>
			</div><br/>
<?php 
		} 
		if($Condiments_set4!=NULL)	
		{  $q5=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q<?php echo $i;?>. Please add drink options. (Required) <!--You may have to select the below as well.--></h5>
				<?php  
					foreach($Condiments_set4 as $set4)
					{	?>
					<div class="col-md-3"> 
						<input type="radio" name="Condiments_set4" onclick="Show_next('<?php echo '#'.$q5; ?>');" value="<?php echo $set4['condiments_set4_code'].':'.$set4['condiments_set4_name']; ?>">&nbsp;&nbsp;<?php echo $set4['condiments_set4_name']; ?> 
					</div>
			<?php	}   $i=$i+1;?>
			</div><br/>
<?php 	} 
		if($Condiments_set5!=NULL)	
		{  	$q6=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q<?php echo $i;?>. Please add drink temprature. (Required)<!--You are just one step towards making it complete and I am sure you will like it. (Required)--></h5>
				<?php  
					foreach($Condiments_set5 as $set5)
					{	?>
					<div class="col-md-3"> 
						<input type="radio" name="Condiments_set5" onclick="Show_next('<?php echo '#'.$q6; ?>');" value="<?php echo $set5['condiments_set5_code'].':'.$set5['condiments_set5_name'];  ?>">&nbsp;&nbsp;<?php echo $set5['condiments_set5_name']; ?> 
					</div>
			<?php	}  $i=$i+1; ?>
			</div><br/>
<?php 	} 
		if($Condiments_set6!=NULL)	
		{ $q7=$i+1; ?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q<?php echo $i;?>. Please add drink options!</h5>
				<?php  
					foreach($Condiments_set6 as $set6)
					{	?>
					<div class="col-md-3"> 
						<input type="checkbox" name="Condiments_set6" value="<?php echo $set6['condiments_set6_code']; ?>">&nbsp;&nbsp;
						<?php echo $set6['condiments_set6_name']; ?> 
					</div>
			<?php	}  ?>
			</div><br/>
<?php 	} ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" align="center" onclick="add_to_cart_condiments('<?php echo $Merchandise_item_id; ?>', '<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $Merchandize_item_name); ?>', '<?php echo $price; ?>', '<?php echo $Delivery_method; ?>','<?php echo $Branch; ?>',<?php echo $Merchandise_item_id; ?>, '<?php echo $Item_size; ?>',<?php echo $Item_Weight; ?>,<?php echo $Weight_unit_id; ?>,<?php echo $Partner_id; ?>, '<?php echo $Partner_state; ?>', '<?php echo $Partner_Country_id; ?>',<?php echo $Seller_id; ?>,<?php echo $Merchant_flag; ?>, '<?php echo $Cost_price; ?>', '<?php echo $VAT; ?>', '<?php echo $Product_category_id; ?>','<?php echo $Item_code; ?>','<?php echo $Merchandize_item_name; ?>');">Click Ok</button>
			</div>
		</div>
	</div>

<script>
$( "#close_modal" ).click(function(e)
{
	$('#item_info_modal').hide();
	$("#item_info_modal").removeClass( "in" );
});

/* $(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#item_info_modal').hide();
		$("#item_info_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	$( "#close_modal2" ).click(function(e)
	{
		$('#item_info_modal').hide();
		$("#item_info_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});	
}); */

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
	$(flag).css("display","");
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