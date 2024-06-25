<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>css_slider/etalage.css">
<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.etalage.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php $i=1; 
$Condiments_compulsary= array(); ?>
<script>
$( document ).ready(function() 
{
    // Show_next('<?php echo '#'.$i; ?>');
	// alert('<?php echo $Condiments_set1; ?>');
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
		$Condiments_compulsary = 0;
		
		//****Main ITem QUESTION
			if($MainItemQuestions != NULL)	
			{ 
				//echo "main requires and options are<br>".count($MainItemQuestions);
			//	print_r($MainItemQuestions);echo "<br><br>";		
			?>
				<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
					
				<?php 
					foreach($MainItemQuestions as $que=>$Menuitem)
					{
						$set1 = 0;		
				 ?>
					<?php 
						if(count($Menuitem) == 1)
						{
							foreach($Menuitem as $lp1)
							{

							?>
							<div class="col-md-3" style="display:none;"> 
								<input type="radio" checked name="Main_Required_Que_set" onclick="Show_next_required('<?php echo '#'.$q0; ?>');" value="<?php echo $lp1->Company_merchandize_item_code; ?>"><?php echo $lp1->Merchandize_item_name; ?>
							</div>
					<?php		
							}
						}
						else if(count($Menuitem) > 1)
						{
							$Condiments_compulsary++;
							$q0=$i+1;		
							echo "<h5> &nbsp; &nbsp; Q  $i:".$que."</h5>";	
							
							foreach($Menuitem as $lp1)
							{

							?>
							<div class="col-md-3"> 
								<input type="radio" required name="Main_Required_Que_set" onclick="Show_next_required('<?php echo '#'.$q0; ?>');" value="<?php echo $lp1->Company_merchandize_item_code; ?>">&nbsp;&nbsp;<?php echo $lp1->Merchandize_item_name; 
								if($lp1->Billing_price > 0)
									{
										echo "(".$lp1->Billing_price.")";
									}
									?> 
							</div>
					<?php		
							}
							
							$i=$i+1; 
						}
					?>
				</div> <br/>
			<?php 	
					}
				
			
			}
			
		//****Main ITem condiments REQUIRED QUESTIONS 
			if($main_prepare_req_condiments != NULL)	
			{ 
				//echo "main requires and options are<br>";
			//	print_r($main_prepare_req_condiments);echo "<br><br>";	
				foreach($main_prepare_req_condiments as $main_req_condiments41)
				{
			?>
				<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
					
				<?php 	
					foreach($main_req_condiments41 as $que=>$Menuitem)
					{
						if(count($Menuitem) == 1)
						{
							foreach($Menuitem as $lp1)
							{

							?>
							<div class="col-md-3"> 
								<input type="radio" checked name="Main_Required_Condiments_set" value="<?php echo $lp1->Company_merchandize_item_code.':'.$lp1->Merchandize_item_name; ?>">
							</div>
					<?php		
							}	
						}
						else if(count($Menuitem) > 1)
						{
							$Condiments_compulsary++;
							$q1=$i+1;
					//	foreach($Menuitem["question"] as $e)
					//	{
							echo "<h5> &nbsp; &nbsp; Q $i:".$que."</h5>";	
					//	}

							foreach($Menuitem as $lp1)
							{

							?>
							<div class="col-md-3"> 
								<input type="radio" required name="Main_Required_Condiments_set" onclick="Show_next_required('<?php echo '#'.$q1; ?>');" value="<?php echo $lp1->Company_merchandize_item_code.':'.$lp1->Merchandize_item_name; ?>">&nbsp;&nbsp;<?php echo $lp1->Merchandize_item_name; 
								if($lp1->Billing_price > 0)
									{
										echo "(".$lp1->Billing_price.")";
									}
									?> 
							</div>
					<?php		
							}			$i=$i+1; 
						}
					?>
				</div> <br/>
			<?php 	
					}
				}
			
			}
			
		//**** REQUIRED QUESTIONS 
		if($prepare_req_condiments != NULL)	
		{ 
			//echo "requires and options are<br>";
			//print_r($prepare_req_condiments);echo "<br><br>";
			foreach($prepare_req_condiments as $dItem)
			{
				//print_r($dItem);echo "<br><br>";
				foreach($dItem as $que=>$ReqItem)
				{
					//echo "$i:".$que;
					$q2=$i+1;
					$Condiments_compulsary++;
		?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q 
				<?php 
				
						echo "$i:".$que;
					?></h5>
					<?php
							foreach($ReqItem as $reqItem11)
							{
							?>
								<div class="col-md-3"> 
									<input type="radio" required name="Required_Condiments_set_<?php echo $i;?>" onclick="Show_next_required('<?php echo '#'.$q2; ?>');" value="<?php echo $reqItem11->Company_merchandize_item_code.':'.$reqItem11->Merchandize_item_name; ?>">&nbsp;&nbsp;<?php echo $reqItem11->Merchandize_item_name; 
									
									if($reqItem11->Billing_price > 0)
									{
										echo "(".$reqItem11->Billing_price.")";
									}
								?> 
								</div>
							<?php
							}
						
					?>
			</div> <br/>
		<?php 
				$i++; 
				}
				
			}
		
		}
		
		// SIDE QUESTIONS 
		if($Prepare_side_condiments != NULL)	
		{ 
			//print_r($Prepare_side_condiments);

			foreach($Prepare_side_condiments as $dItem)
			{
				
				
				foreach($dItem as $que=>$sideItem)
				{	
					$q3=$i+1;
					$Condiments_compulsary++;
		?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q 
				<?php 
				
						echo "$i:".$que;
						
					?></h5>
					<?php
							foreach($sideItem as $AsideItem)
							{
							?>
								<div class="col-md-3"> 
									<input type="radio" required name="Side_Condiments_set_<?php echo $i;?>" onclick="Show_next('<?php echo '#'.$q3; ?>');" value="<?php echo $AsideItem["Item_code"].':'.$AsideItem["Item_name"].":".$AsideItem["Item_qty"].':'.$AsideItem["Item_rate"]; ?>">&nbsp;&nbsp;<?php echo $AsideItem["Item_name"]; 
									
									if($AsideItem["Item_rate"] > 0)
									{
										echo "(".$AsideItem["Item_rate"].")";
									}
								?> 
								</div>
							<?php
							}
						
					?>
			</div> <br/>
		<?php 
				$i++; 
				}
				
			}
			
		}
		
		// OPTIONAL QUESTIONS
		if($prepare_opt_condiments != NULL)	
		{ 
			//echo "requires and options are<br>";
			//print_r($prepare_opt_condiments);echo "<br><br>";
	
			foreach($prepare_opt_condiments as $dItem)
			{

				foreach($dItem as $que=>$OptItem)
				{	
					$q4=$i+1;
				//	$Condiments_compulsary++;
		?>
			<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
				<h5> &nbsp; &nbsp; Q 
				<?php 
				
						echo "$i:".$que;
					?></h5>
					<?php
							foreach($OptItem as $OptItem11)
							{
							?>
								<div class="col-md-3"> 
									<input type="checkbox" required name="Optional_Condiments_set_<?php echo $i;?>" onclick="Show_next_required('<?php echo '#'.$q4; ?>');" value="<?php echo $OptItem11->Company_merchandize_item_code.':'.$OptItem11->Merchandize_item_name; ?>">&nbsp;&nbsp;<?php echo $OptItem11->Merchandize_item_name; 

								?> 
								</div>
							<?php
							}
						
					?>
			</div> <br/>
		<?php 
				$i++; 
				}
				
			}
		
		}
		
		// ?Main OPTIONAL QUESTIONS
			if($main_prepare_opt_condiments != NULL)	
			{ 
				//echo "main requires and options are<br>";
				//print_r($main_prepare_opt_condiments);echo "<br><br>";
					
				foreach($main_prepare_opt_condiments as $main_opt_condiments41)
				{
			?>
				<div class="row" <?php if($i!=1) { ?> style="display:none;" <?php } ?> id="<?php echo $i; ?>">
					<h5> &nbsp; &nbsp; Q 
				<?php 
					foreach($main_opt_condiments41 as $que=>$Menuitem)
					{
					//	$Condiments_compulsary++;
						$q5=$i+1;
						
					//	foreach($Menuitem["question"] as $e)
					//	{
							echo "$i:".$que;	
					//	}
							
				 ?></h5>
					<?php 
						foreach($Menuitem as $lp2)
						{

						?>
						<div class="col-md-3"> 
							<input type="checkbox" name="Main_Optional_Condiments_set" value="<?php echo $lp2->Company_merchandize_item_code.":".$lp2->Merchandize_item_name; ?>">&nbsp;&nbsp;
							<?php echo $lp2->Merchandize_item_name; 
								if($lp2->Billing_price > 0)
								{
									echo "(".$lp2->Billing_price.")";
								}
							?> 
						</div>
				<?php		
						}			$i=$i+1; 
					?>
				</div> <br/>
			<?php 	
					}
				}
			
			}
		?> 
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="Click_ok" align="center" onclick="add_to_cart_condiments('<?php echo $Merchandise_item_id; ?>', '<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $Merchandize_item_name); ?>', '<?php echo $price; ?>', '<?php echo $Delivery_method; ?>','<?php echo $Branch; ?>',<?php echo $Merchandise_item_id; ?>, '<?php echo $Item_size; ?>',<?php echo $Item_Weight; ?>,<?php echo $Weight_unit_id; ?>,<?php echo $Partner_id; ?>, '<?php echo $Partner_state; ?>', '<?php echo $Partner_Country_id; ?>',<?php echo $Seller_id; ?>,<?php echo $Merchant_flag; ?>, '<?php echo $Cost_price; ?>', '<?php echo $VAT; ?>', '<?php echo $Product_category_id; ?>','<?php echo $Item_code; ?>','<?php echo $Merchandize_item_name; ?>');" <?php if($prepare_req_condiments != NULL || $Prepare_side_condiments != NULL || $main_prepare_req_condiments != NULL)	
		{ echo 'style="display:none;"'; } ?> >Click Ok&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>

<script>
$( "#close_modal" ).click(function(e)
{
	$('#item_info_modal').hide();
	$("#item_info_modal").removeClass( "in" );
});

function add_to_cart_condiments(serial, name, price, Redemption_method, Branch, Company_merchandise_item_id, Item_size, Item_Weight, Weight_unit_id, Partner_id, Partner_state, Partner_Country_id, Seller_id, Merchant_flag, Cost_price, VAT, Product_category_id,Item_code,Item_name)
{	

	//var Required_Condiments_set = $("input:checkbox[name=Required_Condiments_set]:checked").val();	
	//var Required_Condiments_set = $("input[name='Required_Condiments_set']:checked").val();	
	var Required_Condiments_set = [];
	$("input[name^='Required_Condiments']:checked").each(function()
	{
        Required_Condiments_set.push($(this).attr("value"));
    });
	
	var MainRequired_Condiments_set = $("input[name='Main_Required_Condiments_set']:checked").val();	
	var Main_Required_Que_set = $("input[name='Main_Required_Que_set']:checked").val();	
		//console.log(Required_Condiments_set);
		
	var Condiments_set6_optional = [];
	$("input:checkbox[name^=Optional_Condiments]:checked").each(function()
	{
        Condiments_set6_optional.push($(this).attr("value"));
    });
	
	var MainCondiments_set_optional = [];
	$("input:checkbox[name=Main_Optional_Condiments_set]:checked").each(function()
	{
        MainCondiments_set_optional.push($(this).attr("value"));
    });
	
	var Condiments_Sides_set = [];
	$("input[name^='Side_Condiments']:checked").each(function()
	{
        Condiments_Sides_set.push($(this).attr("value"));
    });
	
	$.ajax(
		{
			type: "POST",
			data: {id: serial, name: name, price: price, Delivery_method: 29, Branch: Branch, Item_size: Item_size, Item_Weight: Item_Weight, Weight_unit_id: Weight_unit_id, Partner_id: Partner_id, Partner_state: Partner_state, Partner_Country_id: Partner_Country_id, Seller_id: Seller_id, Merchant_flag: Merchant_flag, Cost_price: Cost_price, VAT: VAT, Product_category_id: Product_category_id,Item_code:Item_code,Required_Condiments_set:Required_Condiments_set,Condiments_set6_optional:Condiments_set6_optional,Condiments_Sides_set:Condiments_Sides_set,MainCondiments_set_optional:MainCondiments_set_optional,MainRequired_Condiments_set:MainRequired_Condiments_set,Selected_Main_Item:Main_Required_Que_set},
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
 
 var radio_count = 0;
 
function Show_next_required(flag)
{
	$(flag).css("display","");
	//$("#Click_ok").css("display","none");
	
	var Condiments_compulsary = '<?php echo $Condiments_compulsary; ?>';

	if ($("input[name^='Required_Condiments']:checked").val())
	{
		radio_count = radio_count+1;
	}
	if ($("input[name='Main_Required_Que_set']:checked").val())
	{
		radio_count = radio_count+1;
	}
	if ($("input[name='Main_Required_Condiments_set']:checked").val())
	{
		radio_count = radio_count+1;
	}
	//alert(Condiments_compulsary+"---"+radio_count);
	if(radio_count == Condiments_compulsary)
	{
		$("#Click_ok").css("display","");
	} 
	else
	{
		return false;	
	}
}

//var radio_count2 = 0; 
	
function Show_next(flag)
{
	$(flag).css("display","");
	//$("#Click_ok").css("display","none");
	
	var Condiments_compulsary = '<?php echo $Condiments_compulsary; ?>';
	
	
	if ($("input[name^='Side_Condiments']:checked").val())
	{
		radio_count = radio_count+1;
	}
	//alert(Condiments_compulsary+"---"+radio_count);
	if(radio_count == Condiments_compulsary)
	{
		$("#Click_ok").css("display","");
	} 
	else
	{
		return false;	
	}
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